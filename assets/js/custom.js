$(document).ready(function() {
    $('.btnLogout').on('click', function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'LOGOUT',
        text: 'Apakah anda yakin ingin Logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = $(this).attr('href');
        }
      })
    })

  
  const rowAlert = $('.alert-row');
  if (rowAlert.length) {
    setTimeout(() => {
      rowAlert.slideUp();
    }, 1800);
  }
})
  