<?php

namespace App\Form;

use App\Entity\Garage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('contact_mail',TextType::class, [
      'attr' => array(
        'readonly' => true,
        'class' => "form-control",
      ),
      'label_attr' => [
        'class' => "form-label" 
      ]
    ])
    ->add('message', TextareaType::class, [
      "mapped"=>false,
      "attr"=> array(
        "class" => "form-control"
      ),
      'label_attr' => [
        'class' => "form-label" 
      ]
    ])
    ->add('mail', TextType::class,[ 
      "mapped"=>false,
      "attr" => array(
        "class" => "form-control"
      ),
      'label_attr' => [
        'class' => "form-label" 
      ]
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garage::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'send_a_message',
        ]);
    }
}
