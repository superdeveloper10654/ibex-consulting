@extends('tenant.layouts.master')

@section('title') @lang('New Measure') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Measures @endslot
        @slot('title') New Measure @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-measure" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Site name" name="site_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" placeholder="Collaborative measure" />
                            </div>
                        </div>

                        <div class="row">
                            <label class="form-label">Measures</label>
                        </div>
                        <div class="accordion text-body" id="accordion">
                            <div class="accordion-item quantified-items">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Quantities</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="accordion-body" style="padding: 0">
                                        <div class="row" style="margin: 0;">
                                            <div id="map-quantified" class="col-md-9" style="height:400px;"></div>
                                            <div class="col-md-3 p-3 text-body">
                                                <small id="add-quant-row-prompt">Please drag a marker to the map</small>
                                                <ul class="list-group mt-3" data-simplebar="init" style="max-height: 390px;">
                                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                                        <div class="simplebar-height-auto-observer-wrapper">
                                                            <div class="simplebar-height-auto-observer"></div>
                                                        </div>
                                                        <div class="simplebar-mask">
                                                            <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                                    <div class="simplebar-content" style="padding: 0px;">
                                                                        <div class="pins-wrapper" title="Drag&drop on map">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                                    </div>
                                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                                    </div>
                                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                        <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="quantified-items-container" class="text-body"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item linear-items">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Dimensions</button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                    <div class="accordion-body" style="padding: 0">
                                        <div class="row" style="margin: 0;">
                                            <div id="map-linear" class="col-md-9" style="height:400px;"></div>
                                            <div class="col-md-3 p-3 text-body">
                                                <small>Select an item and click on map</small>
                                                <div class="pins-wrapper" title="Select item and click on map to create the figure"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="linear-items-list" class="text-body"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row float-end row mt-5 pb-3">
                            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMaps&libraries=drawing,places&v=weekly" async></script>
    <script>
        jQuery(($) => {
            $('#create-measure').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("measures.store") }}', this, {redirect: "{{ t_route('measures') }}"});
            });
        });
    </script>

    <script>
        let maps_conf;

        let map;
        var overlay;
        var iconWidth = 18;
        var iconHeight = 18;
        var markers = [];
        let quant_items = [];
        var line;

        function initMaps() {
            maps_conf = googleMapsDefaultConf();
            maps_conf.center = new google.maps.LatLng(50.67577881920257, -1.2834913927579148);

            map = new google.maps.Map(document.getElementById("map-quantified"), maps_conf);
            overlay = new google.maps.OverlayView();
            overlay.draw = function() {};
            overlay.setMap(map);


            initLinearMap();
        }


        function dragIn(e, icon) {
            var x = e.pageX - $('#map-quantified').offset().left;
            var y = e.pageY - $('#map-quantified').offset().top;
            if (x > 0) {
                var point = new google.maps.Point(x, y);
                var position = overlay.getProjection().fromContainerPixelToLatLng(point);
                generateMarkers(icon, position.lat(), position.lng());
                $(icon).attr('style', 'position: relative; left: 0; top: 0;');
            }
            $("#add-quant-row-prompt").remove();
        }

        function generateMarkers(icon = null, lat = null, lng = null) {
            if (lat == null) {
                lat = map.getCenter().lat();
            }
            if (lng == null) {
                lng = map.getCenter().lng();
            }
            let measure_name = icon.getAttribute('data-name');
            let icon_url = icon.getAttribute('src');
            let quant_item = quant_items.find((el) => el.item_desc == measure_name);
            generateQuantRow(measure_name, icon_url, quant_item.id);

            var new_index = markers.length;
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map,
                draggable: true,
                icon: {
                    url: icon_url,
                    scaledSize: new google.maps.Size(28, 28)
                },
            });
            markers.push(marker);
            $(".quantified-items .lat")[new_index].value = marker.position.lat();
            $(".quantified-items .lng")[new_index].value = marker.position.lng();

            google.maps.event.addListener(marker, 'dragend', function(e) {
                var pixelPosition = getPixelPosition(this);
                if (pixelPosition.x <= 10) {
                } else {
                    var i = markers.findIndex(m => m == marker);
                    $(".quantified-items .lat")[i].value = e.latLng.lat().toFixed(10);
                    $(".quantified-items .lng")[i].value = e.latLng.lng().toFixed(10);
                }
            })
            google.maps.event.addListener(marker, 'drag', function(e) {})


        }

        function getPixelPosition(marker) {
            var scale = Math.pow(2, map.getZoom());
            var nw = new google.maps.LatLng(
                map.getBounds().getNorthEast().lat(),
                map.getBounds().getSouthWest().lng()
            );
            var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
            var worldCoordinate = map.getProjection().fromLatLngToPoint(marker.getPosition());
            var pixelOffset = new google.maps.Point(
                Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
                Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
            );
            return {
                x: pixelOffset.x,
                y: pixelOffset.y,
                right: document.getElementById("map-quantified").clientWidth - pixelOffset.x,
                bottom: document.getElementById("map-quantified").clientHeight - pixelOffset.y
            };
        }

        function generateQuantRow(selected_name, icon_url, rate_card_id) {
            let count = $("#quantified-items-container .quantified-item-line").length;
            var new_quant_row = `
			<div class="row m-3" id="quantified_items">
				<div class="col-md-6">
					<label class="form-label">Quantified item</label>
                        <input type="text" class="form-control" name="quantified_items[${count}][item]" value="${selected_name}" data-icon="${icon_url}" readonly />
					</div>
				<div class="col-md-2">
					<label class="form-label">Latitude</label>
					<input type="text"  class="form-control lat" id="quantified_items[${count}][lat]" name="quantified_items[${count}][lat]">
				</div>
				<div class="col-md-2">
					<label class="form-label">Longitude</label>
					<input type="text" class="form-control lng" id="quantified_items[${count}][lng]" name="quantified_items[${count}][lng]">
				</div>
				<div class="col-md-1">
					<label class="form-label">Quantity</label>
					<input type="number" class="form-control" id="" name="quantified_items[${count}][qty]">
				</div>

				<div class="col-md-1">
					<label class="form-label">Action</label>
					<button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
				</div>
                <input type="hidden" name="quantified_items[${count}][rate_card_id]" value="${rate_card_id}" />
			</div>`;
            $("#quantified-items-container").append(new_quant_row);
        }

        $(document).ready(function() {
            $("#btn_add_quant").click(function() {
                $("#add-quant-row-prompt").remove();
                generateMarkers();
            });

            $(document).on('click', '#quantified-items-container .btn_delete', function() {
                var me = $(this);
                $(".btn_delete").each(function(index, elem) {
                    if (me.is(elem)) {
                        $(this).parent().parent().remove();
                        markers[index].setMap(null);
                        markers.splice(index, 1);
                    }
                });
            });
            $(document).on('change', '.quantified-items .lat', function() {
                var me = $(this);
                $(".quantified-items .lat").each(function(index, elem) {
                    if (me.is(elem)) {
                        markers[index].setPosition(new google.maps.LatLng(parseFloat($('.lat')[index].value), parseFloat($('.lng')[index].value)));
                    }
                });
            });
            $(document).on('change', '.quantified-items .lng', function() {
                var me = $(this);
                $(".quantified-items .lng").each(function(index, elem) {
                    if (me.is(elem)) {
                        markers[index].setPosition(new google.maps.LatLng(parseFloat($('.lat')[index].value), parseFloat($('.lng')[index].value)));
                    }
                });
            });
            $(document).on('change', '.item', function() {
                var me = $(this);
                $(".item").each(function(index, elem) {
                    if (me.is(elem)) {
                        markers[index].setIcon({
                            url: $(elem).find("option:selected").data('icon'),
                            scaledSize: new google.maps.Size(18, 18),
                            target: google.maps.Point(iconWidth / 2, iconHeight / 2),
                            origin: google.maps.Point(iconWidth / 2, iconHeight / 2)
                        }, );
                    }
                });
            });
        });

        // Set the location from the task order list
        function newLocation(newLat, newLng, zoom = 15) {
            let coords = {
                lat: newLat,
                lng: newLng
            };

            map.setCenter(coords);
            map.setZoom(zoom);

            map_linear.setCenter(coords);
            map_linear.setZoom(zoom);
        }

        $(document).ready(function() {
            $('select[name=contract_id]').on('change', function() {
                updateMeasuresMarkers();
            });
        });

        function updateMeasuresMarkers()
        {
            let contract_id = $('select[name=contract_id]').val();

            if (!contract_id) {
                return '';
            }

            $('.accordion-body .list-group .simplebar-wrapper .simplebar-mask .simplebar-offset .simplebar-content-wrapper .simplebar-content .pins-wrapper').html('');
            $('.accordion-item.linear-items .accordion-body .pins-wrapper').html('');

            $.ajax({
                url: "{{ t_route('rate-cards.ajax') }}",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    action      : 'getList',
                    contract_id : contract_id,
                },
                success: (res) => {
                    if (res.success) {
                        if (res.data.length) {
                            quant_items = res.data;

                            res.data.map((rate) => {
                                if (rate.unit == '{{ \AppTenant\Models\Statical\RateCardUnit::ITEM}}') {
                                    let el = $(`<div class="row mb-3">
                                    <div class="col-md-2">
                                        <img src="${rate.pin.icon_url}" data-name="${rate.item_desc}" class="dragicon pt-1 ui-draggable ui-draggable-handle" height="18" width="18" style="position: relative;">
                                    </div>
                                    <div class="col-md-10 p-0 text-body"><small>${rate.item_desc}</small></div>
                                </div>`);
                                    $('.accordion-item.quantified-items .accordion-body .list-group .simplebar-wrapper .simplebar-mask .simplebar-offset .simplebar-content-wrapper .simplebar-content .pins-wrapper').append(el);

                                } else if (rate.unit == '{{ \AppTenant\Models\Statical\RateCardUnit::LINE }}') {
                                    let el = $(`<div class="row py-2 linear-item line" data-line-color="${rate.pin.line_color}" data-line-type="${rate.pin.line_type}" data-rate-card-id="${rate.id}">
                                    <div class="col-2 align-self-center">
                                        <div class="icon" height="3" style="border-bottom: 5px ${rate.pin.line_type} ${rate.pin.line_color}"></div>
                                    </div>
                                    <div class="col-10 p-0 text-body description"><small>${rate.item_desc}</small></div>
                                </div>`);
                                    $('.accordion-item.linear-items .accordion-body .pins-wrapper').append(el);

                                } else if (rate.unit == '{{ \AppTenant\Models\Statical\RateCardUnit::POLYGON}}') {
                                    let el = $(`<div class="row py-2 linear-item polygon" data-fill-color="${rate.pin.fill_color}" data-rate-card-id="${rate.id}">
                                    <div class="col-2 d-flex align-self-center justify-content-center">
                                        <div class="icon" style="background-color:${rate.pin.fill_color};width:17px;height:17px;"></div>
                                    </div>
                                    <div class="col-10 p-0 text-body description"><small>${rate.item_desc}</small></div>
                                </div>`);
                                    $('.accordion-item.linear-items .accordion-body .pins-wrapper').append(el);
                                }
                            });

                            $('.dragicon').draggable({
                                stop: function(e, ui) {
                                    dragIn(e, this);
                                }
                            });
                            $('.dragicon').dblclick(function() {
                                generateMarkers($(this).data('name'));
                            });
                        }

                        $('#quantified-items-container').html('');
                        $('#linear-items-list').html('');
                    } else {
                        errorMsg('Something went wrong');
                    }
                }
            });
        }
    </script>

    <!--------------------------------------------------------
    Linear items functionality START
    ---------------------------------------------------------->
    <script>
        let map_linear;
        let linear_drawing_manager;
        let map_linear_controls;
        let linear_elems = [];

        function initLinearMap() {
            map_linear = new google.maps.Map(document.getElementById("map-linear"), maps_conf);

            linear_drawing_manager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYLINE,
                drawingControl: false,
                drawingControlOptions: false,
            });
            linear_drawing_manager.setMap(null);

            linearMapControls();
        }

        $('.linear-items .pins-wrapper').on('click', '.linear-item', function() {
            $('.linear-items .pins-wrapper .linear-item.active').removeClass('active');
            $(this).addClass('active');

            linear_drawing_manager.setMap(map_linear);
            $(map_linear_controls).show();

            if ($(this).hasClass('line')) {
                if ($(this).data('line-type') == 'solid') {
                    linear_drawing_manager.setOptions({
                        drawingMode: google.maps.drawing.OverlayType.POLYLINE,
                        polylineOptions: {
                            strokeColor: $(this).data('line-color'),
                            editable: true,
                            draggable: true,
                        },
                    });

                } else if (['dotted', 'dashed'].includes($(this).data('line-type'))) {
                    linear_drawing_manager.setOptions({
                        drawingMode: google.maps.drawing.OverlayType.POLYLINE,
                        polylineOptions: {
                            editable: true,
                            draggable: true,
                            strokeOpacity: 0,
                            icons: getPolylineIcons($(this).data('line-type'), $(this).data('line-color')),
                        },
                    });
                }

            } else if ($(this).hasClass('polygon')) {
                linear_drawing_manager.setOptions({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                    polygonOptions: {
                        fillColor: $(this).data('fill-color'),
                        editable: true,
                        draggable: true,
                    }
                });
            }
        });

        $('.linear-items #linear-items-list').on('click', '.btn_delete', function() {
            let line_jq = $(this).closest('.linear-item-line');
            let arr_i = -1;

            let elem = linear_elems.filter((item) => {
                arr_i++;
                return item.data_line_jq.is(line_jq);
            });

            elem[0].shape.overlay.setMap(null);
            linear_elems.splice(arr_i, 1);
            line_jq.remove();
        });

        $(document).on('change', '.coords-wrapper input', function() {
            let line_jq = $(this).closest('.linear-item-line');
            let elem = linear_elems.filter((item) => item.data_line_jq.is(line_jq))[0];

            regenerateLinearShape(elem);
        });

        function linearMapControls() {
            map_linear_controls = document.createElement("div");
            const control_UI = document.createElement("div");

            control_UI.style.marginBottom = "22px";
            control_UI.style.textAlign = "center";
            control_UI.style.display = 'flex';
            map_linear_controls.appendChild(control_UI);

            const cancel_text = document.createElement("div");
            cancel_text.style.fontFamily = "Roboto,Arial,sans-serif";
            cancel_text.style.fontSize = "16px";
            cancel_text.style.color = "#333";
            cancel_text.style.lineHeight = "1";
            cancel_text.style.padding = "5px";
            cancel_text.style.marginRight = "6px";
            cancel_text.style.backgroundColor = "#fff";
            cancel_text.style.border = "2px solid #fff";
            cancel_text.style.borderRadius = "3px";
            cancel_text.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            cancel_text.style.cursor = "pointer";
            cancel_text.innerHTML = "Cancel";
            cancel_text.title = "Click to cancel editing";
            control_UI.appendChild(cancel_text);

            let snap_to_road_checkbox = $(`
                <div class="form-check form-switch">
                    <input class="form-check-input snap-to-road mt-0 me-1" type="checkbox" id="snap_to_road">
                    <label class="form-check-label-1 mb-0" for="snap_to_road" role="button">Snap to road</label>
                </div>
            `)[0];

            snap_to_road_checkbox.style.padding = "5px";
            snap_to_road_checkbox.style.backgroundColor = "#fff";
            snap_to_road_checkbox.style.color = "#333";
            snap_to_road_checkbox.style.border = "2px solid #fff";
            snap_to_road_checkbox.style.borderRadius = "3px";
            snap_to_road_checkbox.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            snap_to_road_checkbox.style.cursor = "pointer";
            snap_to_road_checkbox.style.paddingLeft = "33px";
            snap_to_road_checkbox.style.display = "flex";
            snap_to_road_checkbox.style.alignItems = "center";
            snap_to_road_checkbox.style.disabled = true;

            // @todo temporary disabled - need to fix Snap To Road functional
            $(snap_to_road_checkbox).find('input').attr('disabled', true);

            control_UI.appendChild(snap_to_road_checkbox);

            cancel_text.addEventListener("click", () => {
                linear_drawing_manager.setMap(null);
                $(map_linear_controls).hide();
                $('.linear-items .linear-item.active').removeClass('active');
            });

            google.maps.event.addListener(linear_drawing_manager, 'overlaycomplete', async function(shape) {
                if ($('#snap_to_road').is(':checked')) {
                    await runSnapToRoad(shape).then(() => {
                        shapeCreated(shape);
                    });

                } else {
                    shapeCreated(shape);
                }


            });

            $(map_linear_controls).hide();
            map_linear.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(map_linear_controls);
            map_linear.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(map_linear_controls);
        }

        // Snap a user-created polyline to roads and draw the snapped path
        async function runSnapToRoad(shape) {
            return new Promise(resolve => {
                var path = shape.overlay.getPath();
                var pathValues = [];

                for (var i = 0; i < path.getLength(); i++) {
                    pathValues.push(path.getAt(i).toUrlValue());
                }

                $.get('https://roads.googleapis.com/v1/snapToRoads', {
                    interpolate: true,
                    key: "{{ env('GOOGLE_MAPS_KEY') }}",
                    path: pathValues.join('|')
                }, function(data) {
                    if (data.warningMessage) {
                        errorMsg(data.warningMessage);
                    } else {
                        let coords = processSnapToRoadResponse(data);
                        shape.overlay.setPath(coords);

                        resolve();
                    }
                });
            });
        }

        // Store snapped polyline returned by the snap-to-road service.
        function processSnapToRoadResponse(data) {
            snappedCoordinates = [];

            for (var i = 0; i < data.snappedPoints.length; i++) {
                var latlng = new google.maps.LatLng(
                    data.snappedPoints[i].location.latitude,
                    data.snappedPoints[i].location.longitude);
                snappedCoordinates.push(latlng);
            }

            return snappedCoordinates;
        }


        function shapeCreated(shape) {
            linear_drawing_manager.setMap(null);
            $(map_linear_controls).hide();

            let active_line_jq = $('.linear-items .linear-item.active');
            let coords = shape.overlay.getPath().getArray().toString().split('),').map((item) => item.replace('(', '').replace(')', '').split(', '));
            let data_line_jq = generateLinearItemRow(active_line_jq, coords);
            active_line_jq.removeClass('active');

            linear_elems.push({
                object_line_jq: active_line_jq,
                data_line_jq: data_line_jq,
                shape: shape,
            });

            initLinearShapeEventListeners(shape);
        }

        function initLinearShapeEventListeners(shape) {
            google.maps.event.addListener(shape.overlay.getPath(), 'set_at', function(index, obj) {
                regenerateItemCoords(linear_elems[linear_elems.length - 1]);
            });
            google.maps.event.addListener(shape.overlay.getPath(), 'insert_at', function(index, obj) {
                regenerateItemCoords(linear_elems[linear_elems.length - 1]);
            });
        }

        function generateLinearItemRow(selected_line_jq, coords) {
            let count = $("#linear-items-list .linear-item-line").length;
            var row = `
			<div class="row m-3 linear-item-line" data-line-id="${count}">
                <input type="hidden" name="linear_items[${count}][rate_card_id]" value="${selected_line_jq.attr('data-rate-card-id')}" />
				<div class="col-md-5">
					<label class="form-label">Linear item</label>
                        <input class="form-control item" name="linear_items[${count}][description]" value="${selected_line_jq.find('.description').text()}" readonly>
					</div>
				<div class="col-md-2">
					<label class="form-label">Length</label>
					<input type="text" class="form-control lat" name="linear_items[${count}][length]" step=".01" />
				</div>
				<div class="col-md-2">
					<label class="form-label">Width</label>
					<input type="text" class="form-control lng" name="linear_items[${count}][width]" step=".01" />
				</div>
				<div class="col-md-2">
					<label class="form-label">Depth</label>
					<input type="number" class="form-control" name="linear_items[${count}][depth]" step=".01" />
				</div>
				<div class="col-md-1">
					<label class="form-label">Action</label>
					<button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
				</div>
				<div class="col-12"></div>
				<div class="col-md-5 text-end mt-2 pt-2" style="display: none">Lat/Lng:</div>
				<div class="col-md-7">
					<div class="coords-wrapper mt-2" style="display: none">`;

            row += linearItemCoordsHtml(coords, count);
            row += `
					</div>
				</div>
			</div>`;

            let row_jq = $(row);
            $("#linear-items-list").append(row_jq);

            return row_jq;
        }

        function linearItemCoordsHtml(coords, row_id) {
            let rows = '';

            coords.map((coord, i) =>
                rows += `
				<div class="row">
					<div class="col-md-6 mb-2">
						<input type="text" class="form-control lat" name="linear_items[${row_id}][coords][${i}][lat]" value="${Number(coord[0]).toFixed(10)}">
					</div>
					<div class="col-md-6 mb-2">
						<input type="text" class="form-control lng" name="linear_items[${row_id}][coords][${i}][lng]" value="${Number(coord[1]).toFixed(10)}">
					</div>
				</div>`
            );

            return rows;
        }

        function regenerateItemCoords(item) {
            let coords = item.shape.overlay.getPath().getArray().toString().split('),').map((item) => item.replace('(', '').replace(')', '').split(', '));
            let line_jq = item.data_line_jq;
            let new_coords_html = linearItemCoordsHtml(coords, line_jq.data('line-id'));

            line_jq.find('.coords-wrapper').html(new_coords_html);
        }

        function regenerateLinearShape(item) {
            let coords = [];

            $.each($(item.data_line_jq).find('.coords-wrapper .row'), (i, el) => {
                coords.push({
                    lat: parseFloat($(el).find('input.lat').val()),
                    lng: parseFloat($(el).find('input.lng').val()),
                });
            });

            item.shape.overlay.setPath(coords);
            initLinearShapeEventListeners(item.shape);
        }
    </script>
@endsection
