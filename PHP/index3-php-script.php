
<!-- Add required CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<!-- Add custom CSS to remove underlines -->

<script>
    function hideWelcomeMessage() {
        var message = document.getElementById('message');
        if (message) {
            message.style.display = 'none';
        }
    }
    setTimeout(hideWelcomeMessage, 60000);
</script>

<style>
    a {
        text-decoration: none !important;
    }

    .breadcrumb-item a {
        text-decoration: none !important;
    }

    .breadcrumb-item.active {
        text-decoration: none;
    }

    .navbar-brand {
        text-decoration: none !important;
    }

    .alert {
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
        border-radius: 4px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 5000;
        width: 300px;
    }
    footer{
        background-color: #e6ffe6;
    }
</style>

<!-- Add required JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
            if(calendarEl){
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    customButtons: {
                        datePicker: {
                            text: '',
                            icon: 'bi bi-calendar',
                            click: function() {
                                $('#datePickerModal').modal('show');
                            }
                        }
                    },
                    headerToolbar: {
                        left: 'datePicker',
                        center: 'title',
                        right: 'today dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                            <?php 
                            $eventData = [];
                            foreach ($events as $event) {
                                $eventData[] = "{
                                    title: '" . addslashes($event['title']) . "',
                                    start: '" . $event['date'] . "',
                                    description: '" . addslashes($event['description']) . "',
                                    color: 'your_custom_color'
                                }";
                            }
                            echo implode(",", $eventData);
                            ?>
                        ],
                    eventClick: function(info) {
                        alert(info.event.title + "\n" + info.event.start.toLocaleDateString() + "\n" + info.event.extendedProps.description);
                    }
                });
                calendar.render();

                // Initialize date picker
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                }).on('changeDate', function(e) {
                    var date = e.format('yyyy-mm-dd');
                    calendar.gotoDate(date);
                    $('#datePickerModal').modal('hide');
                });
                calendar.render();
            }
        });
</script>

<!-- Date Picker Modal -->
<div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datePickerModalLabel">Choose Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="datepicker"></div>
            </div>
        </div>
    </div>
</div>
