<?php


namespace App\Form;


use App\Entity\User;
use App\Form\Transformations\DescrizioneToUtente;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class UserSelectTextType extends AbstractType
{
    private UserRepository $userRepository;
    private RouterInterface $router;
    private EntityManagerInterface $em;

    /**
     * ClientiSelectTextType constructor.
     */
    public function __construct (UserRepository $userRepository, RouterInterface $router, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new DescrizioneToutente(
                $this->userRepository,
                $options['finder_callback']
            ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // validazione sottoconto
        $resolver->setDefaults([
            'invalid_message' => 'Cliente non trovato',
            'finder_callback' => function (UserRepository $userRepository, string $user_id) {
                $result = $this->userRepository->findOneBy(["user_id" => $user_id]);
                return $result;
            }
        ]);}

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';
//        $class .= 'js-autocomplete';

        $attr['class'] = $class;
//        $attr['data-autocomplete-url'] = $this->router->generate('get_sottoconti_fields');
        $view->vars['attr'] = $attr;
    }
}