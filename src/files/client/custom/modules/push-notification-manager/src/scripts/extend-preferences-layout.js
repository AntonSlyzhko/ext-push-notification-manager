Espo.loader.require('views/preferences/record/edit', function(PreferencesEditRecordView) {
    const coreModifyDetailLayout = PreferencesEditRecordView.prototype.modifyDetailLayout;
    const coreSetup = PreferencesEditRecordView.prototype.setup;

    Object.assign(PreferencesEditRecordView.prototype, {
        setup() {
            this.dynamicLogicDefs = Espo.Utils.clone(this.dynamicLogicDefs || {});
            this.dynamicLogicDefs.fields = Espo.Utils.clone(this.dynamicLogicDefs.fields);
            this.dynamicLogicDefs.fields.defaultPushNotificationProvider = {
                "visible": {
                    "conditionGroup": [
                        {
                            "type": "isTrue",
                            "attribute": "receivePushNotifications"
                        }
                    ]
                },
                "required": {
                    "conditionGroup": [
                        {
                            "type": "isTrue",
                            "attribute": "receivePushNotifications"
                        }
                    ]
                }
            }
            coreSetup.call(this);
        },

        modifyDetailLayout(layout) {
            if (typeof coreModifyDetailLayout === 'function') {
                coreModifyDetailLayout.call(this, layout);
            }

            layout.push(
                {
                    "tabBreak": true,
                    "tabLabel": "$label:PushNotifications",
                    "name": "pushNotifications",
                    "rows": [
                        [
                            {"name": "receivePushNotifications"},
                            false
                        ],
                        [
                            {"name": "defaultPushNotificationProvider"},
                            false
                        ]
                    ]
                }
            );
        }
    });
});
