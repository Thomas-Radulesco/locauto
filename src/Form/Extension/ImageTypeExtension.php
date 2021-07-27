<?php

namespace App\Form\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ImageTypeExtension extends AbstractTypeExtension
{
    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        // return FormType::class to modify (nearly) every field in the system
        return [FileType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // makes it legal for FileType fields to have an image_property option
        $resolver->setDefined(['image_property']);
        $resolver->setDefined(['image_name']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (isset($options['image_property'])) {
            // this will be whatever class/entity is bound to your form (e.g. Media)
            $parentData = $form->getParent()->getData();
            $imageUrl = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, $options['image_property']);
                $imageName = $accessor->getValue($parentData, $options['image_name']);
            }

            // sets an "image_url" variable that will be available when rendering this field
            $view->vars['image_url'] = $imageUrl;
            $view->vars['image_name'] = $imageName;
        }
    }
}