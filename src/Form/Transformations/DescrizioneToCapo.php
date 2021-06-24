<?php


namespace App\Form\Transformations;


use App\Entity\Capi;
use App\Repository\CapiRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DescrizioneToCapo implements DataTransformerInterface
{
    /**
     * @var CapiRepository
     */
    private $capiRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    /**
     * DescrizioneToCapoTransformer constructor.
     */
    public function __construct(CapiRepository $capiRepository, callable $finderCallback)
    {
        $this->capiRepository = $capiRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value){
        if( null === $value )
            return '';

        if(!$value instanceof Capi)
            throw new \LogicException("CapiSelectTextType puo' essere usato solo con oggetti di tipo Capo");

        return $value->getTipo();
    }

    public function reverseTransform($value){

        if(!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $capo = $callback($this->capiRepository, $value);

        if(!$capo)
            throw new TransformationFailedException(sprintf('Nessun capo trovato con descrizione"%s"', $value));

        return $capo;
    }

}