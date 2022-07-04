const Type = {
  Roue: 1,
  Guidon: 2,
  Selle: 3,
  Cadre: 4,
};

const Slot = {
  Roue1: {
    name: "Left Wheel",
    id: 0,
    x: 140,
    y: 270,
  },
  Roue2: {
    name: "Right Wheel",
    id: 1,
    x: 355,
    y: 270,
  },
  Guidon: {
    name: "Handlebar",
    id: 2,
    x: 408,
    y: 148,
  },
  Selle: {
    name: "Seat",
    id: 3,
    x: 230,
    y: 140,
  },
  Cadre: {
    name: "Bike Frame",
    id: 4,
    x: 180,
    y: 200,
  },
};

class Element {
  constructor(id, type, svg) {
    this.svg = svg;
    this.type = type;
    this.id = id;
  }

  getColorsNumber() {
    let i = 0;
    while (this.svg.search("%COLOR" + i + "%") != -1) {
      i++;
    }
    return i;
  }

  getBlackSvg() {
    let i = 0;
    let resultSvg = this.svg;
    while (resultSvg.search("%COLOR" + i + "%") != -1) {
      resultSvg = resultSvg.split("%COLOR" + i + "%").join("black");
      i++;
    }
    return resultSvg;
  }
}

class CustomElement {
  constructor(element, slot, colors) {
    this.element = element;
    this.slot = slot;
    this.colors = colors;
  }

  getId() {
    return this.id;
  }

  getX() {
    return this.slot.x;
  }

  getY() {
    return this.slot.y;
  }

  getSvg() {
    let finalSvg = this.element.svg;
    for (let i = 0; i < this.element.getColorsNumber(); i++) {
      let color = this.colors[i];
      if (color == null) {
        color = "#000000";
      }
      finalSvg = finalSvg.split("%COLOR" + i + "%").join(color);
    }
    return finalSvg;
  }
}

class Editor {
  constructor(editor, build, availibleElements) {
    this.editor = editor;
    this.customElements = [];
    for (const b of build) {
      this.customElements.push(
        new CustomElement(
          availibleElements[b.id],
          getSlotFromId(b.slot),
          b.colors
        )
      );
    }
    this.availibleElements = availibleElements;

    this.redraw();
  }

  redraw() {
    this.editor.html("");
    for (const customElement of this.customElements) {
      this.drawCustomElement(customElement);
    }
  }

  drawCustomElement(customElement) {
    this.editor.append(
      '<div id="' +
        customElement.getX() +
        "-" +
        customElement.getY() +
        '" style="position: absolute;top: ' +
        customElement.getY() +
        "px; left: " +
        customElement.getX() +
        'px">' +
        customElement.getSvg() +
        "</div>"
    );
  }

  changeColor(slot, colors) {
    let ce = this.getCustomElementFromSlot(slot);
    ce.colors = colors;

    this.redraw();
  }

  addCustomElement(id, slot, colors) {
    if (this.availibleElements[id] == null) {
      return;
    }
    let element = this.getCustomElementFromSlot(slot);
    if (element != null) {
      this.modifyCustomElement(slot, id, colors);
    } else {
      element = new CustomElement(this.availibleElements[id], slot, colors);
      this.customElements.push(element);
    }
    this.redraw();
  }

  getCustomElementFromSlot(slot) {
    for (const customElement of this.customElements) {
      if (customElement.slot.x == slot.x && customElement.slot.y == slot.y) {
        return customElement;
      }
    }
    return null;
  }

  modifyCustomElement(slot, newId, colors) {
    for (const key in this.customElements) {
      let elem = this.customElements[key];
      if (elem.slot.x == slot.x && elem.slot.y == slot.y) {
        this.customElements[key] = new CustomElement(
          this.availibleElements[newId],
          slot,
          colors
        );
        return;
      }
    }
  }

  getCustomElements() {
    return this.customElements;
  }

  randomize() {
    for (const key in this.customElements) {
      let customElement = this.customElements[key];
      this.customElements[key] = new CustomElement(
        this.getRandomAvailibleElement(customElement.element.type),
        customElement.slot,
        this.getRandomColors()
      );
    }
    this.redraw();
  }

  getRandomAvailibleElement(type) {
    let result = [];
    for (const key in this.availibleElements) {
      let element = this.availibleElements[key];
      if (element.type == type) {
        result.push(element);
      }
    }
    let i = Math.round(Math.random() * (result.length - 1));
    return result[i];
  }

  getRandomColors() {
    let colors = [];
    for (let i = 0; i < 10; i++) {
      colors.push(random_rgba());
    }
    return colors;
  }
}

function random_rgba() {
  let color = Math.floor(Math.random() * 16777215).toString(16);
  while (color.length < 6) {
    color += "0";
  }
  return "#" + color;
}

function onRandom() {
  editor.randomize();
}

class Menu {
  constructor(editor) {
    this.editor = editor;
    this.selectedSlot = null;

    let $id = getParamId();
    if ($id == null) {
      this.setNewMode();
    }
  }

  selectSlot(slot) {
    $("#shape").html("");
    $("#pickers").html("");
    this.selectedSlot = slot;
    this.displayMenuFromSlot(slot);
    $("#shapeBtn").show();
    $("#shapeName").html("Selected shape: " + slot.name);
  }

  clickOnShape() {
    if (this.selectedSlot == null) {
      return;
    }

    this.displayShape();
  }

  getSelectedColors() {
    let colors = [];
    $(".colorPicker").each(function () {
      colors.push($(this).val());
    });
    return colors;
  }

  updateColors() {
    let colors = this.getSelectedColors();

    this.editor.changeColor(this.selectedSlot, colors);
  }

  setShapes(svgs) {
    $("#shape").html("");
    for (const svg of svgs) {
      let svgContent = $(svg.svg);
      svgContent.click(() => {
        this.editor.addCustomElement(
          svg.name,
          this.selectedSlot,
          this.getSelectedColors()
        );
        this.selectSlot(this.selectedSlot);
      });
      let shape = $('<div class="shape p-2">').append(svgContent);

      $("#shape").append(shape);
    }
  }

  displayMenuFromSlot(slot) {
    let customElement = this.editor.getCustomElementFromSlot(slot);
    if (customElement == null) {
      this.displayShape();
      return;
    }
    this.displayColorPickers(customElement);
  }

  displayColorPickers(customElement) {
    let count = customElement.element.getColorsNumber();
    $("#pickers").html("");
    for (let i = 0; i < count; i++) {
      let input = $(
        '<input type="color" class="colorPicker" pickerid=' +
          i +
          " value=" +
          customElement.colors[i] +
          ">"
      );
      input.change(() => this.updateColors());

      let div = $("<div>")
        .append("<h1>")
        .html("Color #" + (i + 1));
      div.append(input);

      $("#pickers").append(div);
    }
  }

  displayShape() {
    $("#pickers").html("");
    if (this.selectedSlot == Slot.Roue1) {
      this.setShapes(getSvgsFromType(Type.Roue));
    }
    if (this.selectedSlot == Slot.Roue2) {
      this.setShapes(getSvgsFromType(Type.Roue));
    }
    if (this.selectedSlot == Slot.Guidon) {
      this.setShapes(getSvgsFromType(Type.Guidon));
    }
    if (this.selectedSlot == Slot.Selle) {
      this.setShapes(getSvgsFromType(Type.Selle));
    }
    if (this.selectedSlot == Slot.Cadre) {
      this.setShapes(getSvgsFromType(Type.Cadre));
    }
  }

  setNewMode() {
    $("#saveBtn").hide();
  }
}

function loadBuild() {
  let id = getParamId();

  return new Promise(function (resolve, reject) {
    if (id != null) {
      $.ajax({
        url: "/?page=preview&action=getBike&id=" + id,
        method: "GET",
        dataType: "json",
      }).then(function (response) {
        resolve(JSON.parse(response));
      });
    } else {
      let json =
        '[{"id": "roue1", "slot": 0, "colors": ["#FFFFFF", "#FFFFFF"]}, {"id": "roue0", "slot": 1, "colors": ["#FFFFFF", "#FFFFFF"]}, {"id": "guidon1", "slot": 2, "colors": ["#FFFFFF"]}, {"id": "selle0", "slot": 3, "colors": ["#FFFFFF"]}, {"id": "cadre2", "slot": 4, "colors": ["#FFFFFF"]}]';
      resolve(JSON.parse(json));
    }
  });
}

function saveBuild() {
  let result = [];
  for (const customElement of editor.getCustomElements()) {
    result.push({
      id: customElement.element.id,
      slot: customElement.slot.id,
      colors: customElement.colors,
    });
  }
  return JSON.stringify(result);
}

function getAvailibleElements(availibleElements) {
  let elementsAvailible = [];
  for (const name in availibleElements) {
    let elem = new Element(
      name,
      availibleElements[name].type,
      availibleElements[name].svg
    );
    elementsAvailible[name] = elem;
  }
  return elementsAvailible;
}

function getSvgsFromType(type) {
  let svgs = [];
  let aE = editor.availibleElements;
  for (const key in aE) {
    elem = aE[key];
    if (elem.type == type) {
      svgs.push({
        name: elem.id,
        svg: elem.getBlackSvg(),
      });
    }
  }
  return svgs;
}

function onSlot(id) {
  let slot;
  switch (id) {
    case 0:
      slot = Slot.Roue1;
      break;
    case 1:
      slot = Slot.Roue2;
      break;
    case 2:
      slot = Slot.Guidon;
      break;
    case 3:
      slot = Slot.Selle;
      break;
    case 4:
      slot = Slot.Cadre;
      break;
  }
  menu.selectSlot(slot);
}

function onSave() {
  edit();
}

function onCreate() {
  save();
}

function save() {
  $.post("/?page=preview&action=saveBike", { data: saveBuild() }).then(
    (id) => (document.location = "/?page=preview&id=" + id)
  );
}
function edit() {
  $.post("/?page=preview&action=editBike&id=" + getParamId(), {
    data: saveBuild(),
  }).then(() => document.location.reload(false));
}

function onShape() {
  menu.clickOnShape();
}

let editor;
let menu;

$(function () {
  $.ajax({
    url: "/?page=preview&action=getElements",
    method: "GET",
    dataType: "json",
  }).then(function (response) {
    let availibleElements = getAvailibleElements(response);
    loadBuild().then(function (build) {
      loadEditor(build, availibleElements);
    });
  });
});

function loadEditor(build, availibleElements) {
  editor = new Editor($("#draw"), build, availibleElements);
  menu = new Menu(editor);
}

function getParamId() {
  var result = null,
    tmp = [];
  location.search
    .substr(1)
    .split("&")
    .forEach(function (item) {
      tmp = item.split("=");
      if (tmp[0] === "id") result = decodeURIComponent(tmp[1]);
    });
  return result;
}

function getSlotFromId(id) {
  for (const s in Slot) {
    current = Slot[s];
    if (current.id == id) {
      return current;
    }
  }
}
