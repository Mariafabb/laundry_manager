<?php


namespace App\Form;

use App\Form\Transformations\DescrizioneToOrdine;
use App\Repository\OrdiniRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class OrdiniSelectTextType extends AbstractType
{
    private RouterInterface $router;
    private EntityManagerInterface $em;
    private OrdiniRepository $ordiniRepository;

    /**
     * OrdiniSelectTextType constructor.
     */
    public function __construct(OrdiniRepository $ordiniRepository, RouterInterface $router, EntityManagerInterface $em)
    {
        $this->router = $router;
        $this->em = $em;
        $this->ordiniRepository = $ordiniRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new DescrizioneToOrdine(
                $this->ordiniRepository,
                $options['finder_callback']
            ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Ordine non trovato',
            'finder_callback' => function (OrdiniRepository $ordiniRepository, string $ordine_id) {
                $result = $this->ordiniRepository->findOneBy(["ordine_id" => $ordine_id]);
                return $result;
            }
        ]);}

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';
//        $class .= 'js-autocomplete';

        $attr['class'] = $class;
//        $attr['data-autocomplete-url'] = $this->router->generate('get_ordini_fields');
        $view->vars['attr'] = $attr;
    }
}