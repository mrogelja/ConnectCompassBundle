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


``` yml
mr_connect_compass:
    register_listener: true # Is the listener enabled ? Set it to false in Production

    settings:
        proxy_type: [ propel | doctrine | pdo ] # Choose one of them
        connection:
            propel: # If proxy_type : propel
                variable_name_property: ~ # Default to "name"
                variable_value_property: ~ # Default to "value"
                variable_type_property: ~  # Default to "type"
                variable_comment_property: ~  # Default to "comment"
                variable_updated_at_property : ~ # Use it if timestampable behavior is not enabled
                model: ~ # To use a default Propel Model

    templating:
        engine: twig
        views:
            sass_variable:
                list   : ~  # Default to MrConnectCompassBundle:SassVariable:list_content.html.twig
                update : ~  # Default to MrConnectCompassBundle:SassVariable:update_content.html.twig
                delete : ~  # Default to MrConnectCompassBundle:SassVariable:delete_content.html.twig
                add    : ~  # Default to MrConnectCompassBundle:SassVariable:add_content.html.twig
    compass_projects:
        -
            name: [Compass project name]
            path: [Path of the SASS file to dump into]
            settings: ~  # Same structure than mr_connect_compass.settings, every value is overridable
            
```


Todo List
=========

See [Pull requests](https://github.com/mrogelja/ConnectCompassBundle/issues/1)
 
