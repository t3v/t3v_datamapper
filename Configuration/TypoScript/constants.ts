# ----------------------------
# | T3v DataMapper Constants |
# ----------------------------

# === Plugin Constants ===

plugin {
  tx_t3vdatamapper {
    persistence {
      # cat=plugin/tx_t3vdatamapper/persistence; type=boolean; label=Enables the automatic cache clearing when changing data sets
      enableAutomaticCacheClearing = 1

      # cat=plugin/tx_t3vdatamapper/persistence; type=int+; label=The PID of the default storage
      storagePid = 0

      # cat=plugin/tx_t3vdatamapper/persistence; type=boolean; label=Updates the reference index to ensure data integrity
      updateReferenceIndex = 1
    }

    settings {
      extbase {
        # cat=plugin/tx_t3vdatamapper/settings/extbase; type=string; label=The controller extension name
        controllerExtensionName = T3vDataMapper
      }

      # cat=plugin/tx_t3vdatamapper/settings; type=boolean; label=If set, the language overlay record will be applied
      languageOverlay = 1
    }

    view {
      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The path where the layouts are stored
      layoutRootPath = EXT:t3v_datamapper/Resources/Private/Layouts/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The path where the templates are stored
      templateRootPath = EXT:t3v_datamapper/Resources/Private/Templates/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The path where the partials are stored
      partialRootPath = EXT:t3v_datamapper/Resources/Private/Partials/
    }
  }
}