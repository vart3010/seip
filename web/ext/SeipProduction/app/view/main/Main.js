/**
 * This class is the main view for the application. It is specified in app.js as the
 * "autoCreateViewport" property. That setting automatically applies the "viewport"
 * plugin to promote that instance of this class to the body element.
 *
 * TODO - Replace this content of this view to suite the needs of your application.
 */
Ext.define('SeipProduction.view.main.Main', {
    extend: 'Ext.container.Container',
    requires: [
        'SeipProduction.view.main.MainController',
        'SeipProduction.view.main.MainModel',
        'Ext.layout.container.Border',
        'Ext.dashboard.Dashboard',
        'Ext.ux.dashboard.GoogleRssPart',
    ],

    xtype: 'app-main',
    
    controller: 'main',
    viewModel: {
        type: 'main'
    },

    layout: {
        type: 'border'
    },

    items: [{
        id: 'app-header',
        xtype: 'app-header',
        region: 'north'
    },{
        xtype: 'panel',
        bind: {
            title: '{name}'
        },
        region: 'west',
        html: '<ul><li>This area is commonly used for navigation, for example, using a "tree" component.</li></ul>',
        width: 250,
        split: true,
        tbar: [{
            text: 'Button',
            handler: 'onClickButton'
        }]
    },{
        xtype: 'dashboard',
        reference: 'dashboard',
        region: 'center',
        stateful: false,

        columnWidths: [
            0.35,
            0.40,
            0.25
        ],
        parts: {
            productions: {
                viewTemplate: {
                    title: 'Productions',
                    items: [{
                        xtype: 'productions'
                    }]
                }
            }
        },

        defaultContent: [
            {
                type: 'productions',
                columnIndex: 0,
                height: 300
            }
        ]
    }
    ]
});
