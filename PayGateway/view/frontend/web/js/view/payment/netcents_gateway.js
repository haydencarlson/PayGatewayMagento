/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'netcents_gateway',
                component: 'NetCents_PayGateway/js/view/payment/method-renderer/netcents_gateway'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);
