<?php


namespace App\Form;

use App\Form\Transformations\DescrizioneToCapo;
use App\Repository\CapiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class CapiSelectTextType extends AbstractType
{
    private CapiRepository $capiRepository;
    private RouterInterface $router;
    private EntityManagerInterface $em;

    /**
     * CapiSelectTextType constructor.
     */
    public function __construct(CapiRepository $capiRepository, RouterInterface $router, EntityManagerInterface $em)
    {
        $this->capiRepository = $capiRepository;
        $this->router = $router;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new DescrizioneToCapo(
                $this->capiRepository,
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
            'invalid_message' => 'Capo non trovato',
            'finder_callback' => function (CapiRepository $capiRepository, string $capo_id) {
                $result = $this->capiRepository->findOneBy(["capo_id" => $capo_id]);
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