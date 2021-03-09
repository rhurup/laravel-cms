function showLoader(){
    jQuery("#loading-container").fadeIn();
}
function hideLoader(){
    jQuery("#loading-container").fadeOut();
}
function addNotification(title){
    return $.notify('<strong>'+title+'</strong> Do not close this page...', {
        allow_dismiss: false,
        newest_on_top: true,
        type: 'warning'
    });
}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name, _default) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return _default;
}
function eraseCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}

function generateTable(element, path, newBtn, exportBtn){
    if(typeof exportBtn == undefined){
        exportBtn == false;
    }
    if(typeof newBtn == undefined){
        exportBtn == false;
    }


    $(document).on( 'preInit.dt', function (e, settings) {
        console.log( 'preInit.dt: Table initialisation started: '+new Date().getTime() );
        showLoader();
    });
    $(document).on('preXhr.dt', function ( e, settings, data ) {
        console.log("preXhr.dt: Ajax request is made")
        showLoader();
    });

    element.find('tfoot th').each( function () {
        console.log($(this).data("search"))
        if($(this).data("search") != false){
            var title = $(this).text();
            $(this).html( '<div class="col-auto pl-0 ml-0"><input class="form-control" type="text" placeholder="Søg '+title+'"></div>' );
        }else{
            $(this).html('');
        }

    } );

    var _buttons = []
    if(exportBtn == true){
        _buttons.push({
            extend: 'csv',
            text: 'Eksporter (CSV)',
            fieldSeparator: ';'
        });
    }
    if(newBtn == true){
        _buttons.push({
            text: 'Ny',
            className: "btn btn-success btn-"+newBtn,
            action: function ( e, dt, node, config ) {
                $("#newModal").modal("show")
            }
        });
    }

    var dataTable = element.DataTable({
        "lengthMenu": [[50, -1], [50, "<?php echo e(__('datatables.all')); ?>"]],
        "processing": true,
        "serverSide": true,
        'ajax': {
            'url': restUrl + ''+ path,
            'type': 'GET',
            'contentType': 'application/json; charset=utf-8',
            'beforeSend': function (request) {
                request.setRequestHeader("Authorization", "Bearer " + restToken);
            }
        },
        dom: 'Brtip',
        buttons: _buttons,
        "columns": tableCols
    }).on('xhr.dt', function ( e, settings, json, xhr ) {
        console.log("xhr.dt: Ajax request is completed")
        hideLoader();
    }).on( 'init.dt', function () {
        console.log( 'init.dt: Table initialisation complete: '+new Date().getTime() );
        hideLoader();
    });
    dataTable.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'change clear', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        } );
    } );
}

$( document ).ready(function() {
    $("#menu-toggle").click(function(e) {
        if($("#wrapper").hasClass("toggled")){
            setCookie("isSidebarVisible", "1", 7);
        }else{
            setCookie("isSidebarVisible", "0", 7);
        }
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $("#setDarkMode").click(function(e) {
        if($("#wrapper").hasClass("darkmode")){
            setCookie("isDarkModeVisible", "0", 7);
            $("#topNavBar").addClass("navbar-light");
            $("#topNavBar").addClass("bg-light");
            $("#topNavBar").removeClass("navbar-dark");
            $("#topNavBar").removeClass("bg-dark");
            $("table").removeClass("table-dark");
            $("table").removeClass("bg-dark");
            $(".card").removeClass("bg-dark");
        }else{
            setCookie("isDarkModeVisible", "1", 7);
            $("#topNavBar").removeClass("navbar-light");
            $("#topNavBar").removeClass("bg-light");
            $("#topNavBar").addClass("navbar-dark");
            $("#topNavBar").addClass("bg-dark");
            $("table").addClass("table-dark");
            $("table").addClass("bg-dark");
            $(".card").addClass("bg-dark");
        }
        $("#wrapper").toggleClass("darkmode");
    });
    if($("#wrapper").hasClass("darkmode")){
        $("table").addClass("table-dark");
        $("table").addClass("bg-dark");
        $(".card").addClass("bg-dark");
    }

    hideLoader();
});

