<?php
/* -----------------------------------------------------------------------------------------
   BX EU Garan - PDP hook via product_info_end auto-include
   ---------------------------------------------------------------------------------------*/

if (defined('MODULE_BX_EU_GARAN_STATUS') && constant('MODULE_BX_EU_GARAN_STATUS') !== 'True') {
  return;
}

// Fonts/Skript nur auf Seiten laden, auf denen das Label tatsächlich gerendert werden kann
$bxEuGaranRelevantPages = array(
  FILENAME_PRODUCT_INFO,
  FILENAME_SHOPPING_CART,
  FILENAME_ACCOUNT_HISTORY,
  FILENAME_ACCOUNT_HISTORY_INFO,
  FILENAME_CHECKOUT_CONFIRMATION,
  FILENAME_CHECKOUT_PAYMENT,
  FILENAME_CHECKOUT_PAYMENT_ADDRESS,
  FILENAME_CHECKOUT_SHIPPING,
  FILENAME_CHECKOUT_SHIPPING_ADDRESS,
  FILENAME_CHECKOUT_SUCCESS,
);

if (!in_array(basename($_SERVER['SCRIPT_NAME']), $bxEuGaranRelevantPages, true)) {
  return;
}
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
<script>
(function () {
  var CLOSE_TRANSITION_MS = 200;

  function bindHoverLogic(labelSmall) {
    var closeTimeout = null;
    var labelBig = labelSmall.getElementsByClassName('bx-eu-garan-label-big')[0];
    if (!labelBig) return;

    // A11y: Label per Tastatur fokussierbar und als aufklappbares Element ausgezeichnet
    labelSmall.setAttribute('tabindex', '0');
    labelSmall.setAttribute('role', 'button');
    labelSmall.setAttribute('aria-haspopup', 'true');
    labelSmall.setAttribute('aria-expanded', 'false');

    function isOpen() {
      return labelBig.classList.contains('bx-eu-garan-open');
    }

    function openLabel() {
      // Verzögertes Entfernen von bx-eu-garan-top aus vorigem Schließvorgang abbrechen
      if (closeTimeout) {
        clearTimeout(closeTimeout);
        closeTimeout = null;
      }

      // 1. Offen-Klasse hinzufügen
      labelBig.classList.add('bx-eu-garan-open');
      labelSmall.setAttribute('aria-expanded', 'true');

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
    }

    function closeLabel() {
      labelBig.classList.remove('bx-eu-garan-open');
      labelSmall.setAttribute('aria-expanded', 'false');

      // bx-eu-garan-top erst nach Ende der Ausblend-Transition entfernen, sonst springt die Box beim Schließen
      closeTimeout = setTimeout(function () {
        labelBig.classList.remove('bx-eu-garan-top');
        closeTimeout = null;
      }, CLOSE_TRANSITION_MS);
    }

    // Desktop: Hover
    labelSmall.addEventListener('mouseenter', openLabel);
    labelSmall.addEventListener('mouseleave', closeLabel);

    // Touch/Maus-Klick: umschalten statt nur öffnen, damit ein zweiter Tap wieder schließt
    labelSmall.addEventListener('click', function (event) {
      event.preventDefault();
      if (isOpen()) {
        closeLabel();
      } else {
        openLabel();
      }
    });

    // Tastatur: Enter/Leertaste öffnet bzw. schließt, Escape schließt immer
    labelSmall.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ' || event.key === 'Spacebar') {
        event.preventDefault();
        if (isOpen()) {
          closeLabel();
        } else {
          openLabel();
        }
      } else if (event.key === 'Escape' || event.key === 'Esc') {
        closeLabel();
      }
    });

    // Tastatur-Fokus verhält sich wie Hover
    labelSmall.addEventListener('focus', openLabel);
    labelSmall.addEventListener('blur', closeLabel);

    // Tap/Klick außerhalb schließt ein offenes Label (Touch-Geräte ohne mouseleave)
    document.addEventListener('click', function (event) {
      if (isOpen() && !labelSmall.contains(event.target)) {
        closeLabel();
      }
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
