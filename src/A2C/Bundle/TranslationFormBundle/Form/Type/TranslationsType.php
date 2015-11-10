<?php

namespace A2C\Bundle\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use A2C\Bundle\TranslationFormBundle\EventListener\TranslationsListener;

/**
 * Regroup by locales, all translations fields
 *
 * @author David ALLIX
 * @author Gonzalo Vilaseca <gvilaseca@reiss.co.uk>
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 */
class TranslationsType extends AbstractType
{
    private $translationForm;
    private $translationsListener;
    private $localeProvider;

    /**
     *
     * @param TranslationsListener $translationsListener
     * @param \A2lix\TranslationFormBundle\Locale\LocaleProviderInterface          $localeProvider
     */
    public function __construct(TranslationsListener $translationsListener, $localeProvider)
    {
        $this->translationsListener = $translationsListener;
        $this->localeProvider = $localeProvider;
    }

    /**
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->translationsListener);
    }

    /**
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['default_locale'] = $options['default_locale'];
        $view->vars['required_locales'] = $options['required_locales'];
    }

    /**
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'by_reference' => false,
            'empty_data' => function (FormInterface $form) {
                return new \Doctrine\Common\Collections\ArrayCollection();
            },
            'locales' => $this->localeProvider->getLocales(),
            'default_locale' => $this->localeProvider->getDefaultLocale(),
            'required_locales' => $this->localeProvider->getRequiredLocales(),
            'fields' => array(),
            'exclude_fields' => array(),
        ));
    }

    public function getName()
    {
        return 'a2lix_translations';
    }
}