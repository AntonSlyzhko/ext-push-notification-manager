class ExtendPreferencesLayoutHandler {

    constructor(view) {
        /** @type {module:views/record/edit} */
        this.view = view;
    }

    process() {
        this.controlDefaultPushNotificationProvider();
        this.view.listenTo(this.view.model, 'change:receivePushNotifications', () => this.controlDefaultPushNotificationProvider());

        const coreModifyDetailLayout = this.view.modifyDetailLayout;

        this.view.modifyDetailLayout = (layout) => {
            if (typeof coreModifyDetailLayout === 'function') {
                coreModifyDetailLayout.call(this.view, layout);
            }

            const pushTab = layout.find(item => item.name === "pushNotifications");

            const requiredRows = [
                [
                    {"name": "receivePushNotifications"},
                    false
                ],
                [
                    {"name": "defaultPushNotificationProvider"},
                    false
                ]
            ];

            if (!pushTab) {
                layout.push({
                    "tabBreak": true,
                    "tabLabel": "$label:PushNotifications",
                    "name": "pushNotifications",
                    "rows": [...requiredRows]
                });
            } else {
                pushTab.rows.push(...requiredRows);
            }
        }
    }

    controlDefaultPushNotificationProvider() {
        if (this.view.model.get('receivePushNotifications')) {
            this.view.showField('defaultPushNotificationProvider');
            this.view.setFieldRequired('defaultPushNotificationProvider');
        } else {
            this.view.hideField('defaultPushNotificationProvider');
            this.view.setFieldNotRequired('defaultPushNotificationProvider');
        }
    }
}

export default ExtendPreferencesLayoutHandler;
