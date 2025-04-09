import ArrayFieldView from 'views/fields/array';

class AvailablePushNotificationProvidersFieldView extends ArrayFieldView {

    setupOptions() {
        this.params.options = Object.keys(this.getMetadata().get('app.pushNotificationProviders', {}));
    }
}

export default AvailablePushNotificationProvidersFieldView;
