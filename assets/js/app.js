$(function() {
  /*
   * Functions
   **/

  // Reload certificates and populate table
  var reloadCertificates = function() {
    $.ajax({
      type: 'GET'
      , url: 'http://' + window.location.host + '/api/certificates'
      , cache: false
      , success: function(data) {
        // Clear placeholder
        $('table.certificates tbody').html('');
        // Populate <ul> with host <li>'s
        data.data.hosts.forEach(function(certificate) {
          $('table.certificates tbody').append(
            '<tr>' +
            '<th scope="row">' + certificate.id + '</th>' +
            '<td>' + certificate.hostname + '</td>' +
            '<td>' + certificate.expiration + '</td>' +
            '<td>' + certificate.customer + ' (#300123)</td>' +
            '<td>' + certificate.usage + '</td>' +
            '<td><button disabled type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></button> <button disabled type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-minus"></span></button></td>' +
            '</tr>'
          );
        });
      }
    });
  };

  /*
   * Main
   **/

  // Call reloadCertificates()
  reloadCertificates();
});
