# A2C TranslationFormBundle

Este bundle tem o objetivo de alterar o comportamento do [A2lixFormBundle](https://github.com/a2lix/TranslationFormBundle) que é utilizado para renderizar o formulario de multi idiomas

## Funcionalidades Adicionadas

 - Provider para retornar languages de uma determinada Entity
 - Interfaces para implementação do repository e entity
 - Função do twig para renderizar do nome do idioma na aba do formulário
 - EventListener para salvar registro dos idiomas que foram adicionado conteúdo
 - Configuração da entity que vai conter os idiomas

## Instalação

Adicionar no composer a instalação do A2lixFormBundle

    composer require a2lix/translation-form-bundle

Adicionar as seguintes linhas no arquivo **app/AppKernel.php**

```php
# app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
        new A2C\Bundle\TranslationFormBundle\A2CTranslationFormBundle(),
        new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(),
        // ...
    );
}
```

## Configuração

Configuração do **app/config/config.yml**

```yaml

# Translate Form a2lix
a2lix_translation_form:
    locale_provider: locale_doctrine_provider
    locales: [en_US]
    default_locale: en_US
    manager_registry: doctrine
    templating: "A2CTranslationFormBundle::default.html.twig"

#A2C TranslationForm
a2_c_translation_form:
    class_language_provider: A2C\Bundle\LanguageBundle\Entity\Language
    
```

## Utilizando

Para utilizar você deve implementar as 2 interface disponíveis 
 
- A2C\Bundle\TranslationFormBundle\Locale\EntityInterface.php
- A2C\Bundle\TranslationFormBundle\Locale\RepositoryInterface.php

Deve ficar algo mais ou menos assim:

```php
# src/AppBundle/Entity/Language.php

<?php

namespace AppBundle\Entity;

use A2C\Bundle\CoreBundle\Entity\BaseEntity;
use A2C\Bundle\TranslationFormBundle\Locale\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Language
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LanguageRepository")
 * @ORM\Table(name="language")
 */
class Language extends BaseEntity implements EntityInterface
{
    // --------
    
    /**
     * @ORM\Column(name="acron",type="string",length=2,nullable=false)
     */
    private $acron;

    /**
     * @ORM\Column(name="locale",type="string",length=5,nullable=false)
     */
    private $locale;
    
    public function getAcron()
    {
        return $this->acron;
    }

    public function getLocale()
    {
        return $this->locale;
    }
    
    // --------
}
```
```php
# src/AppBundle/Entity/Repository/LanguageRepository.php

<?php

namespace AppBundle\Entity\Repository;

use A2C\Bundle\TranslationFormBundle\Locale\RepositoryInterface;
use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository implements RepositoryInterface
{
    // --------

    /**
     * @return array
     */
    public function getAllLocale()
    {
        $queryBuilder = $this->createQueryBuilder('l');

        $queryBuilder->orderBy('l.orderBy','DESC');

        $query = $queryBuilder->getQuery();

        $query->useResultCache(true,60,md5('a2c_cache_locale_provider'));

        return $query->getResult();
    }
    
    // --------
}
```