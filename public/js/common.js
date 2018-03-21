/*WAMP connection*/
ab.connect(
    'ws://127.0.0.1:8888',
    onOpen,
    onClose
);


/*Work with WAMP*/
function onOpen() {
    session = arguments[0];
    publish('application.init');

    session['subscribe']('application.level.turned_on', levelTurnedOn);
    session['subscribe']('application.level.turned_off', levelTurnedOff);
    session['subscribe']('application.level.doors_open', levelDoorsOpened);
    session['subscribe']('application.level.doors_close', levelDoorsClose);
    session['subscribe']('application.winch.start_move', winchStartMove);
    session['subscribe']('application.winch.arrive_to_level', winchArriveToLevel);
}

function onClose() {
    console.log('Connection Close');
}

function publish(topic, data) {
    if (typeof session === 'undefined') {
        return log('error - session undefined', 'Connection closed');
    }

     data = typeof data !== 'undefined' ? data : {};

    session.publish(topic, data);
}


/*Handle messages*/
function levelTurnedOn(topic,data) {
    var data = JSON.parse(data);
    if(data.direction == 1)
    {
        $('.elevator-level[data-number="'+data.level+'"]').find('.call-button').first().addClass('active');
    }
    if(data.direction == 0)
    {
        $('.elevator-level[data-number="'+data.level+'"]').find('.call-button').last().addClass('active');
    }
    console.log('Button turned On', data);
    publish('application.winch.do_start_move');
}

function levelTurnedOff(topic,data) {
    var data = JSON.parse(data);
    if(data.direction == 1)
    {
        $('.elevator-level[data-number="'+data.level+'"]').find('.call-button').first().removeClass('active');
    }

    if(data.direction == 0)
    {
        $('.elevator-level[data-number="'+data.level+'"]').find('.call-button').last().removeClass('active');
    }

    console.log('Buttons turned off',data);
}

function levelDoorsOpened(topic,data) {
    data = JSON.parse(data);
    $('.elevator-level[data-number="'+data.level+'"]').find('.door').addClass('opened');
    console.log('Doors are opened', data);
    publish('application.level.do_close_door',{level:data.level});
}

function levelDoorsClose(topic,data) {
    data = JSON.parse(data);
    $('.elevator-level[data-number="'+data.level+'"]').find('.door').removeClass('opened');
    console.log('Doors are closed', data);
    publish('application.client.close_door');
}

function winchStartMove(topic,data) {
    data = JSON.parse(data);
    if(data.direction == 2)
    {
        $('.direction').removeClass('down');
        $('.direction').addClass('up');
    }
    else if(data.direction == 1)
    {
        $('.direction').removeClass('up');
        $('.direction').addClass('down');
    }
    else
    {
        $('.direction').removeClass('up');
        $('.direction').removeClass('down');
    }
    console.log('Winch Start Move!!!');
    console.log(data);
    publish('application.winch.do_move');
}

function winchArriveToLevel(topic,data) {
    data = JSON.parse(data);
    $('.indicator .level').text(data.level+1);
    console.log('Winch Has Arrive!!!');
    console.log(data);
    publish('application.dispatcher.on_arrive_to_level',{level:data.level});
}



$('.call-button').click(function () {
    var level = parseInt($(this).closest('.elevator-level').data('number'));
    var direction = parseInt($(this).data('direction'));

    publish('application.level.call', {
        level: level,
        direction: direction
    });
});





function log(data) {
    console.log(data);
}