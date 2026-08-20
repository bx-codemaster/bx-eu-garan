<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan - PDP hook via product_info_end auto-include
   ---------------------------------------------------------------------------------------*/
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
<script>
(function () {
  var CLOSE_TRANSITION_MS = 200;

  function bindHoverLogic(labelSmall) {
    var closeTimeout = null;

    labelSmall.addEventListener('mouseenter', function () {
      var labelBig = labelSmall.getElementsByClassName('bx-eu-garan-label-big')[0];
      if (!labelBig) return;

      // Verzögertes Entfernen von bx-eu-garan-top aus vorigem Schließvorgang abbrechen
      if (closeTimeout) {
        clearTimeout(closeTimeout);
        closeTimeout = null;
      }

      // 1. Offen-Klasse hinzufügen
      labelBig.classList.add('bx-eu-garan-open');

      // 2. Platz im Viewport berechnen
      var rect = labelSmall.getBoundingClientRect();
      var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      var spaceBelow = viewportHeight - rect.bottom;
      var bigHeight = labelBig.offsetHeight || 250;

      // 3. Ausrichtung nach oben/unten festlegen
      if (spaceBelow < bigHeight && rect.top > bigHeight) {
        labelBig.classList.add('bx-eu-garan-top');
      } else {
        labelBig.classList.remove('bx-eu-garan-top');
      }
    });

    labelSmall.addEventListener('mouseleave', function () {
      var labelBig = labelSmall.getElementsByClassName('bx-eu-garan-label-big')[0];
      if (!labelBig) return;

      labelBig.classList.remove('bx-eu-garan-open');

      // bx-eu-garan-top erst nach Ende der Ausblend-Transition entfernen, sonst springt die Box beim Schließen
      closeTimeout = setTimeout(function () {
        labelBig.classList.remove('bx-eu-garan-top');
        closeTimeout = null;
      }, CLOSE_TRANSITION_MS);
    });
  }

  function setupHoverLogic() {
    var labelSmallList = document.getElementsByClassName('bx-eu-garan-label-small');
    for (var i = 0; i < labelSmallList.length; i++) {
      bindHoverLogic(labelSmallList[i]);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupHoverLogic);
  } else {
    setupHoverLogic();
  }
})();
</script>
