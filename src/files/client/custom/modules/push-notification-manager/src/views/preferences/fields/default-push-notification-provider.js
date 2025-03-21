import EnumFieldView from 'views/fields/enum';

class DefaultPushNotificationProviderFieldView extends EnumFieldView {

    setupOptions() {
        super.setupOptions();

        this.params.options = this.getMetadata().get(`app.pushNotificationProviders.providers`, [])
            .filter(provider => !provider.disabled)
            .map(provider => provider.name);
        this.params.options.unshift("");
    }
}

export default DefaultPushNotificationProviderFieldView;
