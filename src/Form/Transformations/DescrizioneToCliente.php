<?php


namespace App\Form\Transformations;


use App\Entity\Clienti;
use App\Repository\ClientiRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DescrizioneToCliente implements DataTransformerInterface
{
    /**
     * @var ClientiRepository
     */
    private $clientiRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    /**
     * DescrizioneToContoTransformer constructor.
     */
    public function __construct(ClientiRepository $clientiRepository, callable $finderCallback)
    {
        $this->clientiRepository = $clientiRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value){
        if( null === $value )
            return '';

        if(!$value instanceof Clienti)
            throw new \LogicException("ClientiSelectTextType puo' essere usato solo con oggetti di tipo Clienti");

        return $value->getNome()." ".$value->getCognome();
    }

    public function reverseTransform($value){

        if(!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $cliente = $callback($this->clientiRepository, $value);

        if(!$cliente)
            throw new TransformationFailedException(sprintf('Nessun cliente trovato con descrizione"%s"', $value));

        return $cliente;
    }

}