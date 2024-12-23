function editOrder(id) {
    save_method = 'update';
    $('#form')[0].reset();
    $.ajax({
      url: `${base_url}dashboard/orders/update/${id}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(respond) {
        $('#id').val(respond.data[0].id);
        $('#tanggal_db').val(respond.data[0].tanggal_db);
        $('#alamat_db').val(respond.data[0].alamat_db);
        $('#luas_sawah').val(respond.data[0].luas_sawah);
        $('#jenis_tanaman').val(respond.data[0].jenis_tanaman);
        $('#admin').val(respond.data[0].admin);
        $('#modal').modal('show');
        $('.modal-title').text('Edit Order');
        $('#select').remove();

        const statusValue = respond.data[0].status;
        const statusSelect = $('#status');
        statusSelect.empty();
  
        const defaultOption = $('<option>').text('Pilih Status').attr('selected', 'selected');
        statusSelect.append(defaultOption);
  
        if (statusValue === 'menunggu_konfirmasi') {
          const dalamProgresOption = $('<option>').val('dalam_progres').text('Konfirmasi Tindaklanjuti');
          const menungguKonfirmasi = $('<option>').val('menunggu_konfirmasi').text('Menunggu Konfirmasi');
          menungguKonfirmasi.attr('selected', 'selected');
          statusSelect.append(menungguKonfirmasi, dalamProgresOption);
        } else if (statusValue === 'dalam_progres') {
          const selesaiOption = $('<option>').val('selesai').text('Selesai');
          const dalamProgresOption = $('<option>').val('dalam_progres').text('Proses Tindaklanjuti');
          dalamProgresOption.attr('selected', 'selected');
          statusSelect.append(dalamProgresOption, selesaiOption);
        }
  
        $('#addOrderModal').modal('show');
        $('.modal-title').text('Temuan');
        $('#select').remove();
        $('#status_order').removeAttr('hidden');
      },
      error: function(respond) {
        const { icon, title, text } = respond;
        Swal.fire({
          icon,
          title,
          text,
        });
      }
    });
  }
  

  function saveOrder() {
    const id = $("#id").val();
    const username = $("#username").val();
    const url = id ? base_url + 'dashboard/orders/update/' + id : base_url + 'dashboard/client/' + username;
    
    $.post(url, $('#form').serialize())
        .done(respond => {
            Swal.fire({
                icon: respond.icon,
                title: respond.title,
                text: respond.text,
                timer: 3000,
                showCancelButton: false,
                showConfirmButton: false
            }).then(() => location.reload());
        })
        .fail(respond => {
            if (respond.status == false) {
                Swal.fire({
                    icon: respond.icon,
                    title: respond.title,
                    text: respond.text,
                });
            }
        });
} 

const modal = document.getElementById("modal");
const closeBtn = document.getElementsByClassName("close")[0];

function closeModal() {
  modal.style.display = "none";
  location.reload();
}

closeBtn.onclick = closeModal;

window.onclick = function(event) {
  if (event.target == modal) {
    closeModal();
  }
}