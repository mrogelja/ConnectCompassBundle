ConnectCompassBundle
====================

This bundle is aimed at managing SASS variable from a data store system.

```

--------------        ------------------------    dump    ------------------------
- Data store -  <---> - ConnectCompassBundle - <--------> - SASS variables files -
--------------        ------------------------    load    ------------------------

```

Configuration
=============

Propel
------

``` yml
mr_connect_compass:
    register_listener: true

    settings:
        proxy_type: propel
        connection:
            propel:
                variable_name_property: name
                variable_value_property: value
                variable_type_property: type
                variable_comment_property: comment
                variable_updated_at_property : ~ # Use it if timestampable behavior is not enabled
                model: ~ # To use a default Propel Model

    templating:
        engine: twig
        views:
            sass_variable:
                list   : ~ Default to MrConnectCompassBundle:SassVariable:list_content.html.twig
                update : ~ Default to MrConnectCompassBundle:SassVariable:update_content.html.twig
                delete : ~ Default to MrConnectCompassBundle:SassVariable:delete_content.html.twig
                add    : ~ Default to MrConnectCompassBundle:SassVariable:add_content.html.twig
    compass_projects:
        -
            name: [Compass project name]
            settings: ~ # Same structure than mr_connect_compass.settings, every value is overridable
            
            path: '%kernel.root_dir%/../src/Hypermedia/MinisiteFidelCastroBundle/Resources/public/compass/sass/source/_vars.scss'
```
