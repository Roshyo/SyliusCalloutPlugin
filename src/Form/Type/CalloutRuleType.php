<?php

declare(strict_types=1);

namespace Setono\SyliusCalloutsPlugin\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

final class CalloutRuleType extends AbstractConfigurableCalloutRuleType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', CalloutRuleChoiceType::class, [
                'label' => 'setono_sylius_callouts_plugin.ui.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ])
        ;
    }
}
