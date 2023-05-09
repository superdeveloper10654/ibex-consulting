let html = "";
let answers = {};
let workflowId = 0;
// let originalData = {
//   "class": "go.GraphLinksModel",
//   "linkFromPortIdProperty": "fromPort",
//   "linkToPortIdProperty": "toPort",
//   "nodeDataArray": [
//     { "category": "Start", "text": "Start", "key": -1, "loc": "-354 -183.0625" },
//     { "category": "Statement", "text": "Statement", "key": -2, "loc": "-158 -145.0625" },
//     { "category": "Dropdown", "text": "Dropdown", "key": -4, "loc": "-319 -51.0625" },
//     { "category": "Statement", "text": "Statement", "key": -5, "loc": "-152 -75.0625" },
//     { "category": "Statement", "text": "Statement", "key": -6, "loc": "-152 2.9375" }
//   ],
//   "linkDataArray": [
//     { "from": -1, "to": -2, "fromPort": "R", "toPort": "L", "points": [-323.5, -183.0625, -313.5, -183.0625, -259.8138427734375, -183.0625, -259.8138427734375, -145.0625, -206.127685546875, -145.0625, -196.127685546875, -145.0625] },
//     { "from": -2, "to": -4, "fromPort": "B", "toPort": "T", "points": [-158, -129.523583984375, -158, -119.523583984375, -158, -105.58195800781249, -319, -105.58195800781249, -319, -91.64033203125, -319, -81.64033203125] },
//     { "from": -4, "to": -5, "fromPort": "R", "toPort": "L", "points": [-243.24462890625, -51.0625, -233.24462890625, -51.0625, -216.6861572265625, -51.0625, -216.6861572265625, -75.0625, -200.127685546875, -75.0625, -190.127685546875, -75.0625] },
//     { "from": -4, "to": -6, "fromPort": "B", "toPort": "L", "points": [-319, -20.484667968749996, -319, -10.484667968749996, -319, 2.9375000000000018, -259.5638427734375, 2.9375000000000018, -200.127685546875, 2.9375000000000018, -190.127685546875, 2.9375000000000018] }
//   ]
// };

function getNode(key) {
  if (!key) {
    html = '';
    let itr = myDiagram.findNodesByExample({ "category": "Start" })
    while (itr.next()) return itr.value.part.data;
  } else return myDiagram.findNodeForKey(key).part.data;
}

function getLinks(cond) {
  let links = [];
  let itr = myDiagram.findLinksByExample(cond);
  while (itr.next()) links.push(itr.value.part.data);
  return links;
}

function getChildren(key) {
  let children = [];
  let links = getLinks({ from: key });
  for (let link of links) {
    children.push(getNode(link.to));
  }
  return children;
}

function getChildrenRecursive(key, ary) {
  ary = ary || [];
  ary.push(key);
  let children = getChildren(key);
  for (let child of children) {
    getChildrenRecursive(child.key, ary);
  }
  return ary
    .filter((v, i, a) => a.indexOf(v) === i)  // unique array
    .filter((v) => v !== key);                // exclude current question key
}

function getParents(key) {
  let parents = [];
  let links = getLinks({ to: key });
  for (let link of links) {
    parents.push(getNode(link.from));
  }
  return parents;
}

function getParentsRecursive(key) {
  console.log(key);
}

function doAnswer(qid, answer) {
  let children = getChildrenRecursive(qid);
  for (let child of children) {
    delete answers[child];
  }
  answers[qid] = answer;
  generateForm();
  console.log('answers', answers)
  // document.getElementById("myAnswer").value = JSON.stringify(answers);
}

function generateForm(key) {
  let node = getNode(key);
  if (!node) return;
  key = node.key;

  let links = getLinks({ from: key });
  let children = getChildren(key);
  let parents = getParents(key);

  if (node.category === "Statement" || node.category === "Description") {
    if (parents[0].category !== "Dropdown") {
      html += `<li class="pb-2">${node.text}</li>`;
    }
  }

  if (node.category === "Dropdown") {
    html += `<div class="row p-1 mb-1 border-bottom">`;
    html += `<div class="pb-2">${node.text}</div>`;
    for (let child of children) {
      html += `<label>
        <input type="radio" 
          name="${key}" 
          value="${child.key}" 
          onchange="doAnswer(${key}, ${child.key})" 
          ${child.key === answers[key] ? ' checked' : ''}
        />${child.text}
      </label>`;
    }
    html += `</div>`;
  }

  if (node.category === "Condition") {
    html += `<div class="row p-1 mb-1 border-bottom">`;
    html += `<div class="pb-2">${node.text}</div>`;
    for (let child of ['Yes', 'No']) {
      html += `<label>
        <input type="radio" 
          name="${key}" 
          value="${child}" 
          onchange="doAnswer(${key}, '${child}')" 
          ${child === answers[key] ? ' checked' : ''}
        />${child}
      </label>`;
    }
    html += `</div>`;
  }

  if (node.category === "End") {
    html += `<div><button class="btn btn-primary btn-rounded w-md waves-effect waves-light">Save</button></div>`;
  }

  if (links.length > 0) {
    if (node.category === 'Dropdown') {
      if (answers[key]) {
        updateForm(answers[key]);
      }
    } else if (node.category === 'Condition') {
      let ans = null;
      if (answers[key] === 'No') {
        ans = links.find(v => v.text === 'No');
      } else if (answers[key] === 'Yes') {
        ans = links.find(v => v.text === 'Yes');
      }
      if (ans) {
        updateForm(ans?.to)
      }
    } else {
      updateForm(links[0].to);
    }

  } else {
    return;
  }
}

function updateForm(key) {
  generateForm(key);
  document.getElementById("previewDiv").innerHTML = html;
}

function initWorkflow(editable = true) {
  // document.getElementById("mySavedModel").innerHTML = JSON.stringify(data);

  if (window.goSamples) goSamples(); // init for these samples -- you don't need to call this
  var $ = go.GraphObject.make; // for conciseness in defining templates

  myDiagram = $(
    go.Diagram,
    "myDiagramDiv", // must name or refer to the DIV HTML element
    {
      isReadOnly: !editable,
      initialContentAlignment: go.Spot.Center,
      allowDrop: true, // must be true to accept drops from the Palette
      LinkDrawn: showLinkLabel, // this DiagramEvent listener is defined below
      LinkRelinked: showLinkLabel,
      scrollsPageOnFocus: false,
      "undoManager.isEnabled": true // enable undo & redo
    }
  );
  // myDiagram.grid.visible = true;
  myDiagram.grid.gridCellSize = new go.Size(10, 10);
  myDiagram.toolManager.draggingTool.isGridSnapEnabled = true;
  // myDiagram.toolManager.draggingTool.gridSnapCellSpot = go.Spot.TopLeft;
  // myDiagram.toolManager.resizingTool.isGridSnapEnabled = true;

  myDiagram.addDiagramListener("TextEdited", function (e) {
    updateForm();
  });
  myDiagram.addDiagramListener("LinkDrawn", function (e) {
    updateForm();
  });
  myDiagram.addDiagramListener("LinkRelinked", function (e) {
    updateForm();
  });
  myDiagram.addDiagramListener("LinkReshaped", function (e) {
    updateForm();
  });
  myDiagram.addDiagramListener("SelectionDeleted", function (e) {
    updateForm();
  });

  // when the document is modified, add a "*" to the title and enable the "Save" button
  myDiagram.addDiagramListener("Modified", function (e) {
    updateForm();

    // var button = document.getElementById("SaveButton");
    // if (button) button.disabled = !myDiagram.isModified;
    // var idx = document.title.indexOf("*");
    // if (myDiagram.isModified) {
    //   if (idx < 0) document.title += "*";
    // } else {
    //   if (idx >= 0) document.title = document.title.substr(0, idx);
    // }
  });

  // helper definitions for node templates

  function nodeStyle() {
    return [
      // The Node.location comes from the "loc" property of the node data,
      // converted by the Point.parse static method.
      // If the Node.location is changed, it updates the "loc" property of the node data,
      // converting back using the Point.stringify static method.
      new go.Binding("location", "loc", go.Point.parse).makeTwoWay(
        go.Point.stringify
      ),
      {
        // the Node.location is at the center of each node
        locationSpot: go.Spot.Center
      }
    ];
  }

  // Define a function for creating a "port" that is normally transparent.
  // The "name" is used as the GraphObject.portId,
  // the "align" is used to determine where to position the port relative to the body of the node,
  // the "spot" is used to control how links connect with the port and whether the port
  // stretches along the side of the node,
  // and the boolean "output" and "input" arguments control whether the user can draw links from or to the port.
  function makePort(name, align, spot, output, input) {
    var horizontal = align.equals(go.Spot.Top) || align.equals(go.Spot.Bottom);
    // the port is basically just a transparent rectangle that stretches along the side of the node,
    // and becomes colored when the mouse passes over it
    return $(go.Shape, {
      fill: "transparent", // changed to a color in the mouseEnter event handler
      strokeWidth: 0, // no stroke
      width: horizontal ? NaN : 8, // if not stretching horizontally, just 8 wide
      height: !horizontal ? NaN : 8, // if not stretching vertically, just 8 tall
      alignment: align, // align the port on the main Shape
      stretch: horizontal ? go.GraphObject.Horizontal : go.GraphObject.Vertical,
      portId: name, // declare this object to be a "port"
      fromSpot: spot, // declare where links may connect at this port
      fromLinkable: output, // declare whether the user may draw links from here
      toSpot: spot, // declare where links may connect at this port
      toLinkable: input, // declare whether the user may draw links to here
      cursor: "pointer", // show a different cursor to indicate potential link point
      mouseEnter: function (e, port) {
        // the PORT argument will be this Shape
        if (!e.diagram.isReadOnly) port.fill = "#0000FF22";
      },
      mouseLeave: function (e, port) {
        port.fill = "transparent";
      }
    });
  }

  function textStyle() {
    return {
      // font: "bold 11pt Helvetica, Arial, sans-serif",
      // stroke: "black"
    };
  }

  // define the Node templates for regular nodes

  myDiagram.nodeTemplateMap.add("Statement", $(
    go.Node, "Table", nodeStyle(),
    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
    $(go.Panel, "Auto", $(
      go.Shape, "Rectangle", { fill: "white", stroke: "#556ee6", strokeWidth: 1 }, // blue color
      new go.Binding("figure", "figure")
    ), $(go.TextBlock, textStyle(), {
      margin: 8,
      maxSize: new go.Size(160, NaN),
      wrap: go.TextBlock.WrapFit,
      editable: true
    }, new go.Binding("text").makeTwoWay())),
    // four named ports, one on each side:
    makePort("T", go.Spot.Top, go.Spot.TopSide, false, true),
    makePort("L", go.Spot.Left, go.Spot.LeftSide, true, true),
    makePort("R", go.Spot.Right, go.Spot.RightSide, true, true),
    makePort("B", go.Spot.Bottom, go.Spot.BottomSide, true, false)
  ));

  myDiagram.nodeTemplateMap.add("Dropdown", $(
    go.Node, "Table", nodeStyle(),
    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
    $(go.Panel, "Auto", $(
      go.Shape, "Diamond", { fill: "white", stroke: "black", strokeWidth: 1 },
      new go.Binding("figure", "figure")
    ), $(go.TextBlock, textStyle(), {
      margin: 4,
      maxSize: new go.Size(125, NaN),
      wrap: go.TextBlock.WrapFit,
      editable: true,
      textAlign: "center"
    }, new go.Binding("text").makeTwoWay())),
    // four named ports, one on each side:
    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
    makePort("L", go.Spot.Left, go.Spot.Left, true, true),
    makePort("R", go.Spot.Right, go.Spot.Right, true, true),
    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
  )
  );

  myDiagram.nodeTemplateMap.add("Condition", $(
    go.Node, "Table", nodeStyle(),
    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
    $(go.Panel, "Auto", $(
      go.Shape, "Diamond", { fill: "white", stroke: "black", strokeWidth: 1 },
      new go.Binding("figure", "figure")
    ), $(go.TextBlock, textStyle(), {
      margin: 4,
      maxSize: new go.Size(125, NaN),
      wrap: go.TextBlock.WrapFit,
      editable: true,
      textAlign: "center"
    }, new go.Binding("text").makeTwoWay())),
    // four named ports, one on each side:
    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
    makePort("L", go.Spot.Left, go.Spot.Left, true, true),
    makePort("R", go.Spot.Right, go.Spot.Right, true, true),
    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
  )
  );

  myDiagram.nodeTemplateMap.add("Description", $(
    go.Node, "Table", nodeStyle(),// the main object is a Panel that surrounds a TextBlock with a rectangular Shape
    $(go.Panel, "Auto", $(
      go.Shape, "Procedure", { fill: "white", stroke: "black", strokeWidth: 1 },
      new go.Binding("figure", "figure")
    ), $(go.TextBlock, textStyle(), {
      margin: 8,
      maxSize: new go.Size(160, NaN),
      wrap: go.TextBlock.WrapFit,
      editable: true
    }, new go.Binding("text").makeTwoWay())),
    // four named ports, one on each side:
    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
    makePort("L", go.Spot.Left, go.Spot.Left, true, true),
    makePort("R", go.Spot.Right, go.Spot.Right, true, true),
    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
  )
  );

  myDiagram.nodeTemplateMap.add("Start", $(go.Node,
    "Table", nodeStyle(), $(
      go.Panel, "Auto", $(go.Shape, "Terminator", {
        desiredSize: new go.Size(60, 30),
        fill: "white",
        stroke: "black",
        strokeWidth: 1,
        parameter1: 15
      }),
      $(go.TextBlock, "Start", textStyle(), new go.Binding("text"))
    ),
    // three named ports, one on each side except the top, all output only:
    makePort("L", go.Spot.Left, go.Spot.Left, true, false),
    makePort("R", go.Spot.Right, go.Spot.Right, true, false),
    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
  )
  );

  myDiagram.nodeTemplateMap.add("End", $(
    go.Node, "Table", nodeStyle(), $(
      go.Panel, "Auto", $(go.Shape, "Terminator", {
        desiredSize: new go.Size(60, 30),
        fill: "white",
        stroke: "black",
        strokeWidth: 1,
        parameter1: 15
      }),
      $(go.TextBlock, "End", textStyle(), new go.Binding("text"))
    ),
    // three named ports, one on each side except the bottom, all input only:
    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
    makePort("L", go.Spot.Left, go.Spot.Left, false, true),
    makePort("R", go.Spot.Right, go.Spot.Right, false, true)
  )
  );

  // replace the default Link template in the linkTemplateMap
  myDiagram.linkTemplate = $(
    go.Link, // the whole link panel
    {
      routing: go.Link.AvoidsNodes,
      curve: go.Link.JumpOver,
      corner: 5,
      toShortLength: 4,
      relinkableFrom: true,
      relinkableTo: true,
      reshapable: true,
      resegmentable: true,
      // mouse-overs subtly highlight links:
      mouseEnter: function (e, link) {
        link.findObject("HIGHLIGHT").stroke = "#0000FF22";
      },
      mouseLeave: function (e, link) {
        link.findObject("HIGHLIGHT").stroke = "transparent";
      },
      selectionAdorned: false
    },
    new go.Binding("points").makeTwoWay(),
    $(
      go.Shape, // the highlight shape, normally transparent
      {
        isPanelMain: true,
        strokeWidth: 8,
        stroke: "transparent",
        name: "HIGHLIGHT"
      }
    ),
    $(
      go.Shape, // the link path shape
      { isPanelMain: true, stroke: "gray", strokeWidth: 1 },
      new go.Binding("stroke", "isSelected", function (sel) {
        return sel ? "dodgerblue" : "black";
      }).ofObject()
    ),
    $(
      go.Shape, // the arrowhead
      { toArrow: "standard", strokeWidth: 0, fill: "black" }
    ),
    $(
      go.Panel,
      "Auto", // the link label, normally not visible
      { visible: false, name: "LABEL", segmentIndex: 1, segmentFraction: 0.5 },
      new go.Binding("visible", "visible").makeTwoWay(),
      $(
        go.Shape,
        "RoundedRectangle", // the label shape
        { fill: "white", strokeWidth: 1 }
      ),
      $(
        go.TextBlock,
        "?", // the label
        {
          textAlign: "center",
          font: "var(--bs-body-font-size) var(--bs-body-font-family)",
          stroke: "black",
          editable: true
        },
        new go.Binding("text").makeTwoWay()
      )
    )
  );

  // Make link labels visible if coming out of a "condition" node.
  // This listener is called by the "LinkDrawn" and "LinkRelinked" DiagramEvents.
  function showLinkLabel(e) {
    var label = e.subject.findObject("LABEL");
    if (label !== null)
      label.visible = e.subject.fromNode.data.category === "Condition";
  }

  // temporary links used by LinkingTool and RelinkingTool are also orthogonal:
  myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Orthogonal;
  myDiagram.toolManager.relinkingTool.temporaryLink.routing =
    go.Link.Orthogonal;

  //loadDiagram(); // load an initial diagram from some JSON text

  // initialize the Palette that is on the left side of the page
  myPalette = $(
    go.Palette,
    "myPaletteDiv", // must name or refer to the DIV HTML element
    {
      scrollsPageOnFocus: false,
      nodeTemplateMap: myDiagram.nodeTemplateMap, // share the templates used by myDiagram
      model: new go.GraphLinksModel([
        // specify the contents of the Palette
        { category: "Start", text: "Start" },
        { category: "Statement", text: "Statement" },
        { category: "Description", text: "Description" },
        { category: "Dropdown", text: "Dropdown" },
        { category: "Condition", text: "Yes or No" },
        { category: "End", text: "End" }
        // { category: "Comment", text: "Comment" }
      ])
    }
  );
} // end init

// Show the diagram's model in JSON format that the user may edit
function saveWorkflow(url) {
  let data = JSON.parse(myDiagram.model.toJson());
  data.linkFromPortIdProperty = "fromPort";
  data.linkToPortIdProperty = "toPort";
  let name = $('#workflowName').val();
  let category = $('[name=category]').val();
  if (name == '') {
    infoMsg('Please input workflow name.');
    $('#workflowName').focus();
  } else {
    $.post(url, { id: workflowId, name, data, category: category }, res => {
      window.location.href = $('[name=previous_page]').val();
      
    }).fail((res) => {
      if (typeof res.responseJSON.errors !== 'undefined') {
        for (let key in res.responseJSON.errors) {
            errorMsg(res.responseJSON.errors[key]);
        }
    }
    });
  }
  // console.log($('#mySavedModel'));
  // document.getElementById("mySavedModel").value = myDiagram.model.toJson();
  // myDiagram.isModified = false;
}
function loadWorkflow(data) {
  myDiagram.model = go.Model.fromJson(data);
  // myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
  updateForm();
}

// print the diagram by opening a new window holding SVG images of the diagram contents for each page
function printDiagram() {
  var svgWindow = window.open();
  if (!svgWindow) return; // failure to open a new Window
  var printSize = new go.Size(700, 960);
  var bounds = myDiagram.documentBounds;
  var x = bounds.x;
  var y = bounds.y;
  while (y < bounds.bottom) {
    while (x < bounds.right) {
      var svg = myDiagram.makeSVG({
        scale: 1.0,
        position: new go.Point(x, y),
        size: printSize
      });
      svgWindow.document.body.appendChild(svg);
      x += printSize.width;
    }
    x = bounds.x;
    y += printSize.height;
  }
  setTimeout(function () {
    svgWindow.print();
  }, 1);
}
