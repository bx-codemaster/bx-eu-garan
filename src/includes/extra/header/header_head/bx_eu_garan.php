<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan - PDP hook via product_info_end auto-include
   ---------------------------------------------------------------------------------------*/
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
<style>
  #bx-eu-garan-label-small,
  .bx-eu-garan-label-small {
    display: inline-block;
    max-width: 145px;
    position: relative;
    cursor: pointer;
  }
  #bx-eu-garan-label-small > svg,
  .bx-eu-garan-label-small > svg {
    width: 100%;
    height: auto;
    display: block;
  }
  #bx-eu-garan-label-big,
  .bx-eu-garan-label-big {
    display: none;
    min-width: 360px;
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 5px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    padding: 2px;
    z-index: 1000;
  }
  #bx-eu-garan-label-small:hover #bx-eu-garan-label-big,
  #bx-eu-garan-label-small.bx-eu-garan-open #bx-eu-garan-label-big,
  .bx-eu-garan-label-small:hover .bx-eu-garan-label-big,
  .bx-eu-garan-label-small.bx-eu-garan-open .bx-eu-garan-label-big {
    display: block;
  }
  #bx-eu-garan-label-big svg,
  .bx-eu-garan-label-big svg {
    width: 100%;
    height: auto;
    display: block;
  }
  .bx_eu_garan_labels {
    display:flex;
    align-items:flex-start;
    gap:12px;
    flex-wrap:wrap;
    margin-top: 12px;
  }
  .bx_eu_garan_labels > * {
    flex: 0 0 auto;
  }
  .bx_eu_garan_labels .bx_eu_garan_legal_label_btn {
    display: block;
    max-width: 150px;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var labelSmalls = document.querySelectorAll('#bx-eu-garan-label-small, .bx-eu-garan-label-small');

    if (!labelSmalls || labelSmalls.length === 0) {
      return;
    }

    labelSmalls.forEach(function (labelSmall) {
      var labelBig = labelSmall.querySelector('#bx-eu-garan-label-big, .bx-eu-garan-label-big');
      if (!labelBig) {
        return;
      }

      labelSmall.addEventListener('mouseenter', function () {
        labelSmall.classList.add('bx-eu-garan-open');
      });

      labelBig.addEventListener('mouseleave', function () {
        labelSmall.classList.remove('bx-eu-garan-open');
      });
    });
  });
</script>
