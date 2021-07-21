<?php


namespace App\Form;

use App\Entity\Clienti;
use App\Entity\Ordini;
use App\Form\Transformations\DescrizioneToCliente;
use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ClientiSelectTextType extends AbstractType
{
    private ClientiRepository $clientiRepository;
    private RouterInterface $router;
    private EntityManagerInterface $em;

    /**
     * ClientiSelectTextType constructor.
     */
    public function __construct(ClientiRepository $clientiRepository, RouterInterface $router, EntityManagerInterface $em)
    {
        $this->clientiRepository = $clientiRepository;
        $this->router = $router;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new DescrizioneToCliente(
                $this->clientiRepository,
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
            'finder_callback' => function (ClientiRepository $clientiRepository, string $cliente_id) {
                $result = $this->clientiRepository->findOneBy(["id" => $cliente_id]);
                return $result;
            }
        ]);}

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';

        $attr['class'] = $class;

        $view->vars['attr'] = $attr;
    }
}