(function ($) {
  'use strict';

  function bindDifferentEndToggle($root) {
    var $toggle = $root.find('#rnbei_end_different');
    var $endWrap = $root.find('.rnbei-end-location-wrap');

    function refresh() {
      if ($toggle.is(':checked')) {
        $endWrap.removeAttr('hidden');
      } else {
        $endWrap.attr('hidden', 'hidden');
        $root.find('#rnbei_end_location_address, #rnbei_end_place_id, #rnbei_end_lat, #rnbei_end_lng').val('');
      }
    }

    $toggle.on('change', refresh);
    refresh();
  }

  function attachAutocomplete(inputId, placeIdId, latId, lngId) {
    var input = document.getElementById(inputId);
    if (!input || !window.google || !google.maps || !google.maps.places) {
      return;
    }

    var autocomplete = new google.maps.places.Autocomplete(input, {
      fields: ['formatted_address', 'place_id', 'geometry']
    });

    autocomplete.addListener('place_changed', function () {
      var place = autocomplete.getPlace();
      if (!place) return;

      var formatted = place.formatted_address || input.value || '';
      var placeId = place.place_id || '';
      var lat = place.geometry && place.geometry.location ? String(place.geometry.location.lat()) : '';
      var lng = place.geometry && place.geometry.location ? String(place.geometry.location.lng()) : '';

      input.value = formatted;
      $('#' + placeIdId).val(placeId);
      $('#' + latId).val(lat);
      $('#' + lngId).val(lng);
    });
  }

  window.rnbeiInitPlaces = function () {
    attachAutocomplete('rnbei_start_location_address', 'rnbei_start_place_id', 'rnbei_start_lat', 'rnbei_start_lng');
    attachAutocomplete('rnbei_end_location_address', 'rnbei_end_place_id', 'rnbei_end_lat', 'rnbei_end_lng');
  };

  $(function () {
    var $root = $('[data-rnbei-location-root="1"]');
    if ($root.length) {
      bindDifferentEndToggle($root);
    }
  });
})(jQuery);
