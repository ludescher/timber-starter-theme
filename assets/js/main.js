import $ from 'jquery';

import Manager from './manager/manager';

function initializeComponentBySelector(componentModule, selector) {
    let $componentElements = $(selector);

    $.each($componentElements, function(index, value) {
        let component = componentModule();

        component.$el = $(value);
        component.initialize();
    });
}

$(document).ready(function() {
    initializeComponentBySelector(Manager, 'body');
});