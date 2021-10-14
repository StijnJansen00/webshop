let backpack = "noBackpack"
let backpackSet
let cover = "noCover"
let coverSet
let label = "noLabel"
let labelSet
let agenda = "noAgenda"
let agendaSet
let etui = "noEtui"
let etuiSet
let pen = "noPen"
let penSet
let pencil = "noPencil"
let pencilSet
let ruler = "noRuler"
let rulerSet
let geoRuler = "noGeoRuler"
let geoRulerSet
let paper = "noPaper"
let paperSet
let stitcher = "nostitcher"
let stitcherSet

function selectBackpack(selectedBackpackId) {
    const selectedBackpack = document.getElementById(selectedBackpackId)
    let optionsBackpack = document.getElementsByClassName("backpack")
    let noBackpack = document.getElementById("noBackpack")

    for (const item of optionsBackpack) {
        if (item.id === selectedBackpackId) {
            if (selectedBackpack.classList.contains("active")) {
                selectedBackpack.classList.remove("active")
                backpack = "noBackpack"
                backpackSet = true
            } else {
                selectedBackpack.classList.add("active")
                backpack = selectedBackpack.id
                backpackSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (backpackSet) {
        noBackpack.classList.add("active")
    }
    console.log(backpack)
}

function selectCover(selectedCoverId) {
    const selectedCover = document.getElementById(selectedCoverId)
    let optionsCover = document.getElementsByClassName("cover")
    let noCover = document.getElementById("noCover")

    for (const item of optionsCover) {
        if (item.id === selectedCoverId) {
            if (selectedCover.classList.contains("active")) {
                selectedCover.classList.remove("active")
                cover = "noCover"
                coverSet = true
            } else {
                selectedCover.classList.add("active")
                cover = selectedCover.id
                coverSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (coverSet) {
        noCover.classList.add("active")
    }
    console.log(cover)
}

function selectLabel(selectedLabelId) {
    const selectedLabel = document.getElementById(selectedLabelId)
    let optionsLabel = document.getElementsByClassName("label")
    let noLabel = document.getElementById("noLabel")

    for (const item of optionsLabel) {
        if (item.id === selectedLabelId) {
            if (selectedLabel.classList.contains("active")) {
                selectedLabel.classList.remove("active")
                label = "noLabel"
                labelSet = true
            } else {
                selectedLabel.classList.add("active")
                label = selectedLabel.id
                labelSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (labelSet) {
        noLabel.classList.add("active")
    }
    console.log(label)
}

function selectAgenda(selectedAgendaId) {
    const selectedAgenda = document.getElementById(selectedAgendaId)
    let optionsAgenda = document.getElementsByClassName("agenda")
    let noAgenda = document.getElementById("noAgenda")

    for (const item of optionsAgenda) {
        if (item.id === selectedAgendaId) {
            if (selectedAgenda.classList.contains("active")) {
                selectedAgenda.classList.remove("active")
                agenda = "noAgenda"
                agendaSet = true
            } else {
                selectedAgenda.classList.add("active")
                agenda = selectedAgenda.id
                agendaSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (agendaSet) {
        noAgenda.classList.add("active")
    }
    console.log(agenda)
}

function selectEtui(selectedEtuiId) {
    const selectedEtui = document.getElementById(selectedEtuiId)
    let optionsEtui = document.getElementsByClassName("etui")
    let noEtui = document.getElementById("noEtui")

    for (const item of optionsEtui) {
        if (item.id === selectedEtuiId) {
            if (selectedEtui.classList.contains("active")) {
                selectedEtui.classList.remove("active")
                etui = "noEtui"
                etuiSet = true
            } else {
                selectedEtui.classList.add("active")
                etui = selectedEtui.id
                etuiSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (etuiSet) {
        noEtui.classList.add("active")
    }
    console.log(etui)
}

function selectPen(selectedPenId) {
    const selectedPen = document.getElementById(selectedPenId)
    let optionsPen = document.getElementsByClassName("pen")
    let noPen = document.getElementById("noPen")

    for (const item of optionsPen) {
        if (item.id === selectedPenId) {
            if (selectedPen.classList.contains("active")) {
                selectedPen.classList.remove("active")
                pen = "noPen"
                penSet = true
            } else {
                selectedPen.classList.add("active")
                pen = selectedPen.id
                penSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (penSet) {
        noPen.classList.add("active")
    }
    console.log(pen)
}

function selectPencil(selectedPencilId) {
    const selectedPencil = document.getElementById(selectedPencilId)
    let optionsPencil = document.getElementsByClassName("pencil")
    let noPencil = document.getElementById("noPencil")

    for (const item of optionsPencil) {
        if (item.id === selectedPencilId) {
            if (selectedPencil.classList.contains("active")) {
                selectedPencil.classList.remove("active")
                pencil = "noPencil"
                pencilSet = true
            } else {
                selectedPencil.classList.add("active")
                pencil = selectedPencil.id
                pencilSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (pencilSet) {
        noPencil.classList.add("active")
    }
    console.log(pencil)
}

function selectRuler(selectedRulerId) {
    const selectedRuler = document.getElementById(selectedRulerId)
    let optionsRuler = document.getElementsByClassName("ruler")
    let noRuler = document.getElementById("noRuler")

    for (const item of optionsRuler) {
        if (item.id === selectedRulerId) {
            if (selectedRuler.classList.contains("active")) {
                selectedRuler.classList.remove("active")
                ruler = "noRuler"
                rulerSet = true
            } else {
                selectedRuler.classList.add("active")
                ruler = selectedRuler.id
                rulerSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (rulerSet) {
        noRuler.classList.add("active")
    }
    console.log(ruler)
}

function selectGeoRuler(selectedGeoRulerId) {
    const selectedGeoRuler = document.getElementById(selectedGeoRulerId)
    let optionsGeoRuler = document.getElementsByClassName("geoRuler")
    let noGeoRuler = document.getElementById("noGeoRuler")

    for (const item of optionsGeoRuler) {
        if (item.id === selectedGeoRulerId) {
            if (selectedGeoRuler.classList.contains("active")) {
                selectedGeoRuler.classList.remove("active")
                geoRuler = "noGeoRuler"
                geoRulerSet = true
            } else {
                selectedGeoRuler.classList.add("active")
                geoRuler = selectedGeoRuler.id
                geoRulerSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (geoRulerSet) {
        noGeoRuler.classList.add("active")
    }
    console.log(geoRuler)
}

function selectPaper(selectedPaperId) {
    const selectedPaper = document.getElementById(selectedPaperId)
    let optionsPaper = document.getElementsByClassName("paper")
    let noPaper = document.getElementById("noPaper")

    for (const item of optionsPaper) {
        if (item.id === selectedPaperId) {
            if (selectedPaper.classList.contains("active")) {
                selectedPaper.classList.remove("active")
                paper = "noPaper"
                paperSet = true
            } else {
                selectedPaper.classList.add("active")
                paper = selectedPaper.id
                paperSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (paperSet) {
        noPaper.classList.add("active")
    }
    console.log(paper)
}

function selectStitcher(selectedStitcherId) {
    const selectedStitcher = document.getElementById(selectedStitcherId)
    let optionsStitcher = document.getElementsByClassName("stitcher")
    let noStitcher = document.getElementById("noStitcher")

    for (const item of optionsStitcher) {
        if (item.id === selectedStitcherId) {
            if (selectedStitcher.classList.contains("active")) {
                selectedStitcher.classList.remove("active")
                stitcher = "noStitcher"
                stitcherSet = true
            } else {
                selectedStitcher.classList.add("active")
                stitcher = selectedStitcher.id
                stitcherSet = false
            }
        } else {
            document.getElementById(item.id).classList.remove("active")
        }
    }
    if (stitcherSet) {
        noStitcher.classList.add("active")
    }
    console.log(stitcher)
}

function addPackage() {

    let data =  "backpack=" + backpack +
                "&cover=" + cover +
                "&label=" + label +
                "&agenda=" + agenda +
                "&etui=" + etui +
                "&pen=" + pen +
                "&pencil=" + pencil +
                "&ruler=" + ruler +
                "&geoRuler=" + geoRuler +
                "&paper=" + paper +
                "&stitcher=" + stitcher

    jQuery.ajax({
        type: "POST",
        url: "php/create_school_package.php",
        data: data,
        dataType: "HTML",
        success: function (data) {
            if (data === 'true') {
                toastr.info('Pakket toegevoegd aan winkelwagen')
                setTimeout(function () {
                    window.location.href = 'cart'
                }, 3000);
            }
        }
    })

}