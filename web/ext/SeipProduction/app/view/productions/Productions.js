console.log("Productions loaded...");
Ext.define("SeipProduction.view.productions.Productions",{
    extend: 'Ext.grid.Panel',
    xtype: 'productions',

    requires: [
        'widget.sparklineline'
    ],

    controller: 'productions',

    height: 300,

    store: {
        type: 'productions',
        autoLoad: true
    },

    stripeRows: true,
    columnLines: true,

    // Rapid updates are coalesced and flushed on a timer.
    throttledUpdate: true,

    columns: [{
        text: 'Company',
        flex: 1,
        sortable: true,
        dataIndex: 'name'
    }, {
        text: 'Price',
        width: 75,
        formatter: 'usMoney',
        dataIndex: 'price',
        align: 'right'
    }, {
        text: 'Trend',
        width: 100,
        dataIndex: 'trend',
        xtype: 'widgetcolumn',
        widget: {
            xtype: 'sparklineline',
            tipTpl: 'Price: {y:number("0.00")}'
        }
    }, {
        text: 'Change',
        width: 80,
        producesHTML: true,
        renderer: 'renderChange',
        dataIndex: 'change',
        align: 'right'
    }, {
        text: '%',
        width: 70,
        renderer: 'renderChangePercent',
        updater: 'updateChangePercent',
        dataIndex: 'pctChange',
        align: 'right'
    }, {
        text: 'Last Updated',
        hidden: true,
        width: 175,
        sortable: true,
        formatter: 'date("m/d/Y H:i:s")',
        dataIndex: 'lastChange'
    }]
});
