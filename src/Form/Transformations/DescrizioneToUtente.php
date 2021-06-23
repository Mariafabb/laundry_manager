<?php


namespace App\Form\Transformations;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DescrizioneToUtente implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    /**
     * DescrizioneToUtenteTransformer constructor.
     */
    public function __construct(UserRepository $userRepository, callable $finderCallback)
    {
        $this->userRepository = $userRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value){
        if( null === $value )
            return '';

        if(!$value instanceof User)
            throw new \LogicException("UserSelectTextType puo' essere usato solo con oggetti di tipo Utente");

        return $value->getUsername();
    }

    public function reverseTransform($value){

        if(!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $utente = $callback($this->userRepository, $value);

        if(!$utente)
            throw new TransformationFailedException(sprintf('Nessun utente trovato con descrizione"%s"', $value));

        return $utente;
    }

}