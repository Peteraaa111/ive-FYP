$(document).ready( function () {
  // !!! TESTING ONLY !!! //
  $('#clearAll').click( function () {
    $.LoadingOverlay("show");
    setTimeout(function(){
      $.LoadingOverlay("hide");
    }, 500);
    $('#result li').remove();
  })
  $('#reload').click( function () {
    $('#result').load(location.href + " #result");
  })
  $('#changeURL').click( function () {
    var url = '?';
    window.history.replaceState('', 'search', url + 'what=isWhat');
  })
  // !!! TESTING ONLY !!! //

  // Search input click and press 'enter' event handler
  $('#search-btn').click( function () {
    search_keyword();
  })
  $('#search-input').on('keypress', function (e) {
    if (e.which == 13) {
      search_keyword();
    }
  })
  function search_keyword () {
    var search_input = $('#search-input').val();

    // Check if input box has text 
    if($("#search-input").val() != 0) {
      // Check if label is exist
      if ($('#search-label').length == 0) {
        $('#selected-label').show();
        var inputitem =  '<span id="search-label" class="badge bg-secondary" data="' + search_input + '">' + search_input;
        inputitem     += '<button type="button" class="btn-close btn-close-white" aria-label="Close"></button>';
        inputitem     += '</span>';
        $('.selected-badge').append(inputitem);
        search();
      } else {
        $('#search-label').html(search_input + '<button type="button" class="btn-close btn-close-white" aria-label="Close"></button>');
        search();
      }
    } else {
      // Check if label is exist
      console.log('true1');
      if ($('#search-label').length != 0) {
        $('.selected-badge #search-label').remove();
        search();
      }
    }
  }

  // District filter click event handler
  $('.district-item').click( function () {
    var districtName = $(this).find('.district-name').text();
    var districtID = $(this).find('.district-name').attr('value');
    if($("#" + districtID).length == 0){
      $('#selected-label').show();

      var districtitem =  '<span id="' + districtID + '" class="badge bg-info text-black district-label" data="' + districtID + '">' + districtName;
      districtitem     += '<button type="button" class="btn-close btn-close-white" aria-label="Close"></button>';
      districtitem     += '</span>';
      $('.selected-badge').append(districtitem);
      search();
    }
  })

  // cuisine filter click event handler
  $('.cuisine-item').click( function () {
    var cuisineTitle = $(this).find('.cuisine-name').attr('title');
    var cuisineCleanTitle = cuisineTitle.replace(/ /g, '');
    var cuisineName = $(this).find('.cuisine-name').text();
    var cuisineID = $(this).find('.cuisine-name').attr('value');
    if($("#" + cuisineCleanTitle).text().length == 0){
      $('#selected-label').show();

      var cuisineitem = '<span id="' + cuisineCleanTitle + '" class="badge bg-warning text-black cuisine-label" data="' + cuisineID + '">' + cuisineName;
      cuisineitem += '<button type="button" class="btn-close btn-close-white" aria-label="Close"></button>';
      cuisineitem += '</span>';
      $('.selected-badge').append(cuisineitem);
      search();
    }
  })

  // type filter click event handler
  $('.type-item').click( function () {
    console.log(".type-item clicked");
    var typeTitle = $(this).find('.type-name').attr('title');
    var typeCleanTitle = typeTitle.replace(/ /g, '');
    var typeName = $(this).find('.type-name').text();
    var typeID = $(this).find('.type-name').attr('value');
    if($("#" + typeCleanTitle).text().length == 0){
      $('#selected-label').show();

      var typeitem = '<span id="' + typeCleanTitle + '" class="badge bg-success type-label" data="' + typeID + '">' + typeName;
      typeitem += '<button type="button" class="btn-close btn-close-white" aria-label="Close"></button>';
      typeitem += '</span>';
      $('.selected-badge').append(typeitem);
      search();
    }
  })

  // Close button in selected badge click event handler
  $(document).on('click', '.badge .btn-close', function () {
    $(this).closest('.badge').remove();
    search();
  })

  var current_page = 1;
  // Page Link on click function
  $('.page-link').click(function () {
    current_page = $(this).html();
    search();
  })

  // Search method
  function search() {
    console.log('search()');
    // Initialize url
    var url = '?';
    url += 'page=' + current_page;
    var hasSearchLabel   = $('#search-label').length;
    var hasDistrictLabel = $('.district-label').length;
    var hasCuisineLabel  = $('.cuisine-label').length;
    var hasTypeLabel     = $('.type-label').length;
    if ( hasSearchLabel ) {
      url += '&what=' + $('#search-label').text();
    }
    if ( hasDistrictLabel ) {
      $('.district-label').each( function (index, element) {
        url += '&district[]=' + $(element).attr('data');
      })
    }
    if ( hasCuisineLabel ) {
      console.log('true');
      $('.cuisine-label').each( function (index, element) {
        url += '&cuisine[]=' + $(element).attr('data');
      })
    }
    if ( hasTypeLabel ) {
      $('.type-label').each( function (index, element) {
        url += '&type[]=' + $(element).attr('data');
      })
    }
    if($('.selected-badge').children().length == 1){
      $('#selected-label').hide();
    }
    window.location.replace(url);
    $('#result').load(location.href + " #result");
    $('#pagination').load(location.href + " #pagination");
  }
})