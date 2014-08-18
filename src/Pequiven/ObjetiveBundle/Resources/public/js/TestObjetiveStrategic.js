/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.require([ 'Ext.direct.*', 'Ext.data.*', 'Ext.grid.*', 'Ext.util.Format' ]);

Ext.onReady(function() {
    Ext.direct.Manager.addProvider(Actions.REMOTING_API);
    
    Ext.define('ACME.model.Role', {
        extend: 'Ext.data.Model',
        fields: ['id', 'level', 'description', 'level_name'],

        proxy: {
          type: 'direct',
          api: {
              read: Actions.AcmeDemo_Demo.getRoles
          }
        }
    });

Ext.define('ACME.store.Role', {
  extend: 'Ext.data.Store',
  model: 'ACME.model.Role',
  autoLoad: true
});

Ext.create('Ext.grid.Panel', {
    title: 'Objetives',
    store: 'ACME.store.Role',
    columns: [
        { text: 'Level',  dataIndex: 'level' },
        { text: 'Description', dataIndex: 'description'},
        { text: 'LevelName', dataIndex: 'level_name' }
    ],
    height: 200,
    width: 400,
    renderTo: Ext.getBody()
});
});