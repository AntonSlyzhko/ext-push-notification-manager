import EnumFieldView from 'views/fields/enum';

class DefaultPushNotificationProviderFieldView extends EnumFieldView {

    setupOptions() {
        super.setupOptions();

        const providers = this.getHelper().getAppParam('availablePushNotificationProviders') || [];
        this.params.options = ['', ...providers];
    }
}

export default DefaultPushNotificationProviderFieldView;
