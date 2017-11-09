# --------------------------------
# | T3v DataMapper Configuration |
# --------------------------------

plugin {
  tx_t3vdatamapper {
    persistence {
      enableAutomaticCacheClearing = {$plugin.tx_t3vdatamapper.persistence.enableAutomaticCacheClearing}

      storagePid = {$plugin.tx_t3vdatamapper.persistence.storagePid}

      updateReferenceIndex = {$plugin.tx_t3vdatamapper.persistence.updateReferenceIndex}
    }

    settings {
      languageOverlay = {$plugin.tx_t3vdatamapper.settings.languageOverlay}
    }

    view {
      layoutRootPaths {
        0 = {$plugin.tx_t3vdatamapper.view.layoutRootPath}
      }

      templateRootPaths {
        0 = {$plugin.tx_t3vdatamapper.view.templateRootPath}
      }

      partialRootPaths {
        0 = {$plugin.tx_t3vdatamapper.view.partialRootPath}
      }
    }
  }
}