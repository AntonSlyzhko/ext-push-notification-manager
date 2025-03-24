import EnumFieldView from 'views/fields/enum';

class DefaultPushNotificationProviderFieldView extends EnumFieldView {

    setupOptions() {
        super.setupOptions();

        const providers = this.getMetadata().get(`app.pushNotificationProviders`, {});
        this.params.options = Object.keys(providers)
            .filter(provider => !providers[provider].disabled);
        this.params.options.unshift("");
    }
}

export default DefaultPushNotificationProviderFieldView;
