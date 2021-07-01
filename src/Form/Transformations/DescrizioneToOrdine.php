<?php


namespace App\Form\Transformations;

use App\Entity\Ordini;
use App\Repository\OrdiniRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DescrizioneToOrdine implements DataTransformerInterface
{
    /**
     * @var OrdiniRepository
     */
    private $ordiniRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    /**
     * DescrizioneToContoTransformer constructor.
     */
    public function __construct(OrdiniRepository $ordiniRepository, callable $finderCallback)
    {
        $this->ordiniRepository = $ordiniRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value){
        if( null === $value )
            return '';

        if(!$value instanceof Ordini)
            throw new \LogicException("OrdineSelectTextType puo' essere usato solo con oggetti di tipo Ordini");

        return $value->getId();
    }

    public function reverseTransform($value){

        if(!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $ordine = $callback($this->ordiniRepository, $value);

        if(!$ordine)
            throw new TransformationFailedException(sprintf('Nessun ordine trovato con descrizione"%s"', $value));

        return $ordine;
    }

}