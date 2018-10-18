$().ready(function() {
    $sidebar = $('.sidebar');
    $sidebar_img_container = $sidebar.find('.sidebar-background');

    $full_page = $('.full-page');

    $sidebar_responsive = $('body > .navbar-collapse');

    window_width = $(window).width();

    // Init Datetimepicker

    if ($("#datetimepicker").length != 0) {
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

        $('.timepicker').datetimepicker({
            //          format: 'H:mm',    // use this format if you want the 24hours timepicker
            format: 'h:mm A', //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

    };
    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

    if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
        if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('show');
        }

    }

});

type = ['primary', 'info', 'success', 'warning', 'danger'];

app = {
    checkFullPageBackgroundImage: function() {
        $page = $('.full-page');
        image_src = $page.data('image');

        if (image_src !== undefined) {
            image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>'
            $page.append(image_container);
        }
    },
    initPassivoPie: function(id, labels, count, title) {
        var color = [];
        for(i = 0; i < 25; i++){
            color.push(
                'rgba('+Math.floor(Math.random() * 255)+','+Math.floor(Math.random() * 255)+','+Math.floor(Math.random() * 255)+',0.2)'
            );
        }

        var ctx = document.getElementById(id).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: count,
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    },
    activeSidebarMini: function(){
        $('.sidebar .collapse').collapse('hide').on('hidden.bs.collapse', function() {
            $(this).css('height', 'auto');
        });

        if (isWindows) {
            $('.sidebar .sidebar-wrapper').perfectScrollbar('destroy');
        }

        $('body').addClass('sidebar-mini');

        $('.sidebar .collapse').css('height', 'auto');
        lbd.misc.sidebar_mini_active = true;
        window.localStorage.setItem('sidebar.mini.active', true);
    },
    inactiveSidebarMini: function () {
        $('body').removeClass('sidebar-mini');
        lbd.misc.sidebar_mini_active = false;
        window.localStorage.setItem('sidebar.mini.active', false);

        if (isWindows) {
            $('.sidebar .sidebar-wrapper').perfectScrollbar();
        }
    },
    toggleNavbar: function(){
        var $btn = $(this);

        if (lbd.misc.sidebar_mini_active == true) {
            app.inactiveSidebarMini();
        } else {
            app.activeSidebarMini();
        }
    },
    initSidebarMini: function(){
        if (window.localStorage && window.localStorage['sidebar.mini.active'] == 'true') {
            app.activeSidebarMini();
        }
    },
}
