        <!-- Vendor js -->
        <script src="{{ asset('admin-assets/js/vendor.min.js') }}"></script>
        <!-- Input Mask js -->
        <script src="{{ asset('admin-assets/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
        <!-- Daterangepicker js -->
        <script src="{{ asset('admin-assets/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('admin-assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Vector Map js -->
        <script src="{{ asset('admin-assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
        </script>
        <script
            src="{{ asset('admin-assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
        </script>
        <!-- App js -->
        <script src="{{ asset('admin-assets/js/app.min.js') }}"></script>
        <!-- Quill Editor js -->
        <script src="{{ asset('admin-assets/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('admin-assets/js/quill-editor.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        @if (Session::has('store_message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ Session('store_message') }}",
                })
            </script>
        @endif
        @if (Session::has('update_message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ Session('update_message') }}",
                })
            </script>
        @endif
        @if (Session::has('delete_message'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ Session('delete_message') }}",
                })
            </script>
        @endif
        @if (Session::has('error_message'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ Session('error_message') }}",
                })
            </script>
        @endif



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(event, href) {
                event.preventDefault();

                Swal.fire({
                    title: "Warning",
                    text: "Are you sure",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    } else {
                        return false;
                    }
                });
            }
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

        <script>
            $(document).ready(function() {
                $('#sortable-tbody').sortable({
                    group: {
                        pull: true,
                        put: true
                    },
                    animation: 200,
                    ghostClass: 'ghost',
                    items: '#sortable-tbody tr',
                    handle: '#sortable-tbody tr',
                    multiDrag: true,
                    avoidImplicitDeselect: true,
                    onEnd: function(evt) {
                        let allRows = $('#sortable-tbody tr');
                        let activeOrderData = [];
                        let orderData = [];

                        let dataIndexArray = [];

                        $(allRows).each(function(index, element) {
                            dataIndexArray.push($(element).data('order'));
                        });
                        dataIndexArray = dataIndexArray.sort((a, b) => a - b);
                        allRows.each(function(index, element) {
                            let newIndex = dataIndexArray[index];
                            $(element).attr('data-order', newIndex);
                        });
                        $(allRows).each(function(index, element) {
                            let id = $(element).data('id');
                            let order = dataIndexArray[index];
                            let obj = {
                                id: id,
                                order: order,
                            }
                            orderData.push(obj);
                        });
                        saveOrderFunction($('#sortable-tbody').data('route'), orderData)
                    },
                });


                function saveOrderFunction(route, orderData) {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        contentType: 'application/json',
                        data: JSON.stringify({
                            data: orderData
                        }),
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Success",
                                showConfirmButton: false,
                                timer: 1000
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Sorğu alınmadı: ' + status);
                        }
                    });
                }
            })
        </script>

        @stack('js')


        </body>

        </html>
