**Pequiven/SEIPBundle/Resources/config/routing/dataLoad/dashboard.yml**
```yaml
pequiven_data_load_dashboard_production:
  path: /production/{typeView}
  defaults: .....
```

**Pequiven/SEIPBundle/DependencyInjection/PequivenSEIPExtension.php**
```php
$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
$loader->load('services.yml');
```

**app/config/config.yml**
```yaml
knp_menu:
  twig:
      template: knp_menu.html.twig
  templating: false
  default_renderer: twig
```

**Pequiven/SEIPBundle/Resources/config/services.yml**
```yaml
parameters:
  knp_menu.menu_builder.class: Pequiven\SEIPBundle\Menu\Template\Developer\BackendMenuBuilder
  knp_menu.voter.request.class: Pequiven\SEIPBundle\Menu\Template\Developer\RequestVoter

services:
  app.menu_builder:
      class: "%knp_menu.menu_builder.class%"
      arguments: ["@knp_menu.factory", "@security.context", "@translator", "@service_container"]
      calls:
          - [ setContainer, [ @service_container ] ]

  app.menu.main:
      class: Knp\Menu\MenuItem # the service definition requires setting the class
      # factory_service: app.menu_builder
      # factory_method: createSidebarMenu
      factory: ["@app.menu_builder", createSidebarMenu]
      arguments: ["@request", "@request_stack"]
      scope: request # needed as we have the request as a dependency here
      tags:
          - { name: knp_menu.menu, alias: main }

  app.menu.voter.request:
      class: "%knp_menu.voter.request.class%"
      arguments: ["@service_container"]
      tags:
          - { name: knp_menu.voter }

  app.twig_string_loader:
      class:        "Twig_Loader_String"

  app.twig_string:
      class:        "%twig.class%"
      arguments:    [@app.twig_string_loader, %knp_menu.renderer.twig.options%]
```

**Pequiven/SEIPBundle/Resources/views/Template/Developer/base.html.twig**
```html
<html class="no-js linen ng-app" lang="{{ app.request.locale }}">
```

**Pequiven/SEIPBundle/Resources/views/Template/Developer/Layout/_sidebar-drop-down-menu.html.twig**
```twig
{% set menu = knp_menu_get('main') %}
{{ knp_menu_render(menu, {'template': 'PequivenSEIPBundle:Template/Developer:menu.html.twig', 'currentClass': 'current navigable-current'}) }}
```

**Pequiven/SEIPBundle/Resources/config/routing/main.yml**
```
Cambiar el segundo pequiven_data_load --> pequiven_data_load_main
```

**Pequiven/MasterBundle/Admin/PeriodAdmin.php**
```
Cambiar $xor = $qb->expr()->orX($qb->expr()->isNull('p_c')); -> isNull('p_c.id'));
```

**Configurar la zona horaria**
```
/etc/php5/apache2/php.ini -> date.timezone = "America/Caracas"

/etc/apache2/apache2.conf -> SetEnv TZ America/Caracas

/etc/mysql/conf.d/mariadb.cnf -> default-time-zone = "America/Caracas"
```