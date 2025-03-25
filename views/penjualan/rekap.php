<?php
session_start();
require '../../functions.php';

$title = 'Rekap Penjualan';
include_once('../../layouts/head_tag.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// Pagination settings
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get province filter if set
$provinceFilter = isset($_GET['province']) ? $_GET['province'] : '';

// Get all provinces for the filter dropdown
$provincesQuery = "SELECT DISTINCT pv.id, pv.provinsi FROM provinces pv 
                  INNER JOIN mahasiswa m ON m.provinsi_id = pv.id 
                  INNER JOIN penjualan p ON p.mahasiswa_id = m.id 
                  ORDER BY pv.provinsi ASC";
$provinces = query($provincesQuery);

// Base query
$baseQuery = "SELECT p.jumlah, p.total, p.created_at AS tanggal, b.judul, b.harga, m.nama_lengkap, pv.provinsi, pv.id as provinsi_id
              FROM penjualan p
              LEFT JOIN buku b ON p.buku_id = b.id
              LEFT JOIN mahasiswa m ON p.mahasiswa_id = m.id
              LEFT JOIN provinces pv ON m.provinsi_id = pv.id";

// Add filter if province is selected
$whereClause = "";
if (!empty($provinceFilter)) {
  $whereClause = " WHERE pv.id = '$provinceFilter'";
}

// Count total records for pagination
$countQuery = $baseQuery . $whereClause;
$totalRecords = count(query($countQuery));
$totalPages = ceil($totalRecords / $limit);

// Final query with pagination
$recaps = $baseQuery . $whereClause . " ORDER BY p.created_at DESC LIMIT $start, $limit";
$recap_data = query($recaps);
?>

<div class="main-wrapper main-wrapper-1">
  <!-- NAVBAR -->
  <?php include_once('../../layouts/navbar.php') ?>

  <!-- SIDEBAR -->
  <?php include_once('../../layouts/sidebar.php') ?>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Rekap Penjualan Buku</h1>
      </div>

      <!-- Add Download Report Button -->
      <div class="row mb-4">
        <div class="col-12">
          <button id="downloadReportBtn" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Download Laporan PDF
          </button>
        </div>
      </div>

      <!-- 📊 CHARTS ROW -->
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Grafik Penjualan Bulanan</h4>
            </div>
            <div class="card-body">
              <canvas id="sellingMonthChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Grafik Persebaran Konsumen</h4>
            </div>
            <div class="card-body">
              <canvas id="customerAreaChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- 📝 RECAP TABLE -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="section-title mt-0">List Data Penjualan</div>

              <!-- Filter Form -->
              <div class="row mb-4">
                <div class="col-md-4">
                  <form id="filterForm" method="get" action="">
                    <div class="input-group">
                      <select name="province" id="provinceFilter" class="form-control">
                        <option value="">Semua Provinsi</option>
                        <?php foreach ($provinces as $province) : ?>
                          <option value="<?= $province['id']; ?>" <?= ($provinceFilter == $province['id']) ? 'selected' : ''; ?>>
                            <?= ucwords($province['provinsi']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Filter</button>
                      </div>
                      <?php if (!empty($provinceFilter)) : ?>
                        <div class="input-group-append">
                          <a href="rekap.php" class="btn btn-secondary">Reset</a>
                        </div>
                      <?php endif; ?>
                    </div>
                    <!-- Keep the page parameter when form is submitted -->
                    <input type="hidden" name="page" value="1">
                  </form>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col" class="text-nowrap">Nama Pembeli</th>
                      <th scope="col">Asal Provinsi</th>
                      <th scope="col">Judul Buku</th>
                      <th scope="col">Jumlah</th>
                      <th scope="col">Harga</th>
                      <th scope="col">Total</th>
                      <th scope="col">Tanggal Transaksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($recap_data) > 0) : ?>
                      <?php $i = $start + 1; ?>
                      <?php foreach ($recap_data as $dt) : ?>
                        <tr>
                          <th scope="row"><?= $i; ?></th>
                          <td><?= ucwords($dt['nama_lengkap']); ?></td>
                          <td class="text-nowrap"><?= ucwords($dt['provinsi']); ?></td>
                          <td><?= ucwords($dt['judul']); ?></td>
                          <td><?= ucwords($dt['jumlah']); ?></td>
                          <td><?= toRupiah($dt['harga']); ?></td>
                          <td><?= toRupiah($dt['total']); ?></td>
                          <td>
                            <?= date('d-m-Y', strtotime($dt['tanggal'])); ?>
                          </td>
                        </tr>
                        <?php $i++; ?>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr>
                        <td colspan="8" class="text-center">Data Penjualan tidak ada.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <?php if ($totalPages > 1) : ?>
                <div class="pagination-container mt-4">
                  <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                      <?php if ($page > 1) : ?>
                        <li class="page-item">
                          <a class="page-link" href="?page=1<?= !empty($provinceFilter) ? '&province=' . $provinceFilter : ''; ?>" aria-label="First">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="?page=<?= $page - 1; ?><?= !empty($provinceFilter) ? '&province=' . $provinceFilter : ''; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>

                      <?php
                      // Show limited page numbers with current page in the middle
                      $startPage = max(1, $page - 2);
                      $endPage = min($totalPages, $page + 2);

                      // Always show first page
                      if ($startPage > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1' . (!empty($provinceFilter) ? '&province=' . $provinceFilter : '') . '">1</a></li>';
                        if ($startPage > 2) {
                          echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                        }
                      }

                      // Display page links
                      for ($i = $startPage; $i <= $endPage; $i++) {
                        $activeClass = ($i == $page) ? 'active' : '';
                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . (!empty($provinceFilter) ? '&province=' . $provinceFilter : '') . '">' . $i . '</a></li>';
                      }

                      // Always show last page
                      if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                          echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . (!empty($provinceFilter) ? '&province=' . $provinceFilter : '') . '">' . $totalPages . '</a></li>';
                      }
                      ?>

                      <?php if ($page < $totalPages) : ?>
                        <li class="page-item">
                          <a class="page-link" href="?page=<?= $page + 1; ?><?= !empty($provinceFilter) ? '&province=' . $provinceFilter : ''; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="?page=<?= $totalPages; ?><?= !empty($provinceFilter) ? '&province=' . $provinceFilter : ''; ?>" aria-label="Last">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                  <div class="text-center mt-2">
                    <small>Showing <?= count($recap_data) ?> of <?= $totalRecords ?> entries</small>
                  </div>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

  <?php include_once('../../layouts/footer.php') ?>
</div>

<!-- Add this script before the closing PHP include for closed_tag.php -->
<script>
  $(document).ready(function() {
    // Auto-submit form when province selection changes
    $('#provinceFilter').on('change', function() {
      // Reset to page 1 when filter changes
      $('input[name="page"]').val(1);
      $('#filterForm').submit();
    });

    // PDF Generation
    $('#downloadReportBtn').on('click', function() {
      generatePDF();
    });

    async function generatePDF() {
      try {
        // Show simple loading message
        const loadingDiv = $('<div class="text-center mt-3 mb-3"><i class="fas fa-spinner fa-spin mr-2"></i> Generating PDF...</div>');
        $('#downloadReportBtn').after(loadingDiv);

        // Initialize jsPDF
        const {
          jsPDF
        } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');

        // Add title
        doc.setFontSize(18);
        doc.text('Rekap Penjualan Buku', 105, 15, {
          align: 'center'
        });

        // Add date
        doc.setFontSize(10);
        const today = new Date();
        doc.text('Tanggal: ' + today.toLocaleDateString('id-ID'), 105, 22, {
          align: 'center'
        });

        // Capture charts as images
        let yPosition = 30;

        // Capture first chart
        if (document.getElementById('sellingMonthChart')) {
          const monthChartCanvas = await html2canvas(document.getElementById('sellingMonthChart'));
          const monthChartImg = monthChartCanvas.toDataURL('image/png');

          // Add chart title
          doc.setFontSize(12);
          doc.text('Grafik Penjualan Bulanan', 105, yPosition, {
            align: 'center'
          });
          yPosition += 5;

          // Add chart image (scaled to fit page width with margins)
          const imgWidth = 180;
          const imgHeight = (monthChartCanvas.height * imgWidth) / monthChartCanvas.width;
          doc.addImage(monthChartImg, 'PNG', 15, yPosition, imgWidth, imgHeight);
          yPosition += imgHeight + 10;
        }

        // Capture second chart
        if (document.getElementById('customerAreaChart')) {
          const areaChartCanvas = await html2canvas(document.getElementById('customerAreaChart'));
          const areaChartImg = areaChartCanvas.toDataURL('image/png');

          // Add chart title
          doc.setFontSize(12);
          doc.text('Grafik Persebaran Konsumen', 105, yPosition, {
            align: 'center'
          });
          yPosition += 5;

          // Add chart image (scaled to fit page width with margins)
          const imgWidth = 180;
          const imgHeight = (areaChartCanvas.height * imgWidth) / areaChartCanvas.width;
          doc.addImage(areaChartImg, 'PNG', 15, yPosition, imgWidth, imgHeight);
          yPosition += imgHeight + 10;
        }

        // Add new page for table data
        doc.addPage();

        // Add table title
        doc.setFontSize(14);
        doc.text('Data Penjualan', 105, 15, {
          align: 'center'
        });

        // Filter information if applicable
        if ($('#provinceFilter').val()) {
          doc.setFontSize(10);
          doc.text('Filter: Provinsi ' + $('#provinceFilter option:selected').text(), 105, 25, {
            align: 'center'
          });
        }

        // Create table data
        const tableData = [];

        // Add header row
        tableData.push([
          'No',
          'Nama Pembeli',
          'Asal Provinsi',
          'Judul Buku',
          'Jumlah',
          'Harga',
          'Total',
          'Tanggal'
        ]);

        // Add data rows
        $('.table tbody tr').each(function(index) {
          const rowData = [];

          // Skip empty message row
          if ($(this).find('td[colspan]').length) {
            return;
          }

          $(this).find('th, td').each(function(cellIndex) {
            rowData.push($(this).text().trim());
          });

          tableData.push(rowData);
        });

        // Generate table
        doc.autoTable({
          startY: 35,
          head: [tableData[0]],
          body: tableData.slice(1),
          theme: 'grid',
          headStyles: {
            fillColor: [41, 128, 185],
            textColor: 255,
            fontStyle: 'bold'
          },
          styles: {
            fontSize: 8,
            cellPadding: 2
          },
          columnStyles: {
            0: {
              cellWidth: 10
            }, // No
            4: {
              cellWidth: 15
            }, // Jumlah
            5: {
              cellWidth: 25
            }, // Harga
            6: {
              cellWidth: 25
            }, // Total
            7: {
              cellWidth: 25
            } // Tanggal
          }
        });

        // Add pagination info if available
        if ($('.pagination-container small').length) {
          const paginationText = $('.pagination-container small').text();
          doc.setFontSize(8);
          doc.text('Note: ' + paginationText, 15, doc.lastAutoTable.finalY + 10);
        }

        // Remove loading message
        loadingDiv.remove();

        // Open PDF in new tab
        const pdfBlob = doc.output('blob');
        const pdfUrl = URL.createObjectURL(pdfBlob);
        window.open(pdfUrl, '_blank');

        // Also provide a direct download button
        const downloadBtn = $('<button class="btn btn-success ml-2"><i class="fas fa-download"></i> Save PDF</button>');
        $('#downloadReportBtn').after(downloadBtn);

        downloadBtn.on('click', function() {
          doc.save('Rekap_Penjualan_' + today.toISOString().split('T')[0] + '.pdf');
          $(this).remove(); // Remove download button after use
        });

      } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Failed to generate PDF. Please try again.');
      }
    }
  });
</script>

<?php include_once('../../layouts/closed_tag.php') ?>