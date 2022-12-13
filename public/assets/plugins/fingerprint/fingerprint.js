let currentFormat = Fingerprint.SampleFormat.Intermediate;

let FingerprintSdkTest = (function () {
  function FingerprintSdkTest() {
    let _instance = this;
    this.operationToRestart = null;
    this.acquisitionStarted = false;
    // instantiating the fingerprint sdk here
    this.sdk = new Fingerprint.WebApi();
    this.sdk.onDeviceConnected = function (e) {
      // Detects if the device is connected for which acquisition started
      showMessage("Pindai Jari yang Sesuai pada Pembaca", "success");
    };

    this.sdk.onDeviceDisconnected = function (e) {
      // Detects if device gets disconnected - provides deviceUid of disconnected device
      showMessage("Perangkat Terputus. Silahkan Hubungkan Kembali");
    };

    this.sdk.onCommunicationFailed = function (e) {
      // Detects if there is a failure in communicating with U.R.U web SDK
      showMessage("Komunikasi Gagal. Harap Sambungkan Kembali Perangkat");
    };

    this.sdk.onSamplesAcquired = function (s) {
      // Sample acquired event triggers this function
      storeSample(s);
    };
    this.sdk.onQualityReported = function (e) {
      // Quality of sample acquired - Function triggered on every sample acquired
      //document.getElementById("qualityInputBox").value = Fingerprint.QualityCode[(e.quality)];
    };
  }

  // this is were finger print capture takes place
  FingerprintSdkTest.prototype.startCapture = function () {
    if (this.acquisitionStarted)
      // Monitoring if already started capturing
      return;
    let _instance = this;
    showMessage("");
    this.operationToRestart = this.startCapture;
    this.sdk.startAcquisition(currentFormat, "").then(
      function () {
        _instance.acquisitionStarted = true;

        //Disabling start once started
        //disableEnableStartStop();
      },
      function (error) {
        showMessage(error.message);
      }
    );
  };

  FingerprintSdkTest.prototype.stopCapture = function () {
    if (!this.acquisitionStarted)
      //Monitor if already stopped capturing
      return;
    let _instance = this;
    showMessage("");
    this.sdk.stopAcquisition().then(
      function () {
        _instance.acquisitionStarted = false;

        //Disabling stop once stopped
        //disableEnableStartStop();
      },
      function (error) {
        showMessage(error.message);
      }
    );
  };

  FingerprintSdkTest.prototype.getInfo = function () {
    let _instance = this;
    return this.sdk.enumerateDevices();
  };

  FingerprintSdkTest.prototype.getDeviceInfoWithID = function (uid) {
    let _instance = this;
    return this.sdk.getDeviceInfo(uid);
  };

  return FingerprintSdkTest;
})();

class Reader {
  constructor() {
    this.reader = new FingerprintSdkTest();
    this.selectFieldID = null;
    this.currentStatusField = null;
    /**
     * @type {Hand}
     */
    this.currentHand = null;
  }

  readerSelectField(selectFieldID) {
    this.selectFieldID = selectFieldID;
  }

  setStatusField(statusFieldID) {
    this.currentStatusField = statusFieldID;
  }

  displayReader() {
    let readers = this.reader.getInfo(); // grab available readers here
    let id = this.selectFieldID;
    let selectField = document.getElementById(id);
    selectField.innerHTML = `<option>Select Fingerprint Reader</option>`;
    readers.then(function (availableReaders) {
      // when promise is fulfilled
      if (availableReaders.length > 0) {
        showMessage("");
        for (let reader of availableReaders) {
          selectField.innerHTML += `<option value="${reader}" selected>${reader}</option>`;
        }
      } else {
        showMessage("Please Connect the Fingerprint Reader");
      }
    });
  }
}

class Hand {
  constructor() {
    this.id = 0;
    this.index_finger = [];
    this.middle_finger = [];
  }

  addIndexFingerSample(sample) {
    this.index_finger.push(sample);
  }

  addMiddleFingerSample(sample) {
    this.middle_finger.push(sample);
  }

  generateFullHand() {
    let id = this.id;
    let index_finger = this.index_finger;
    let middle_finger = this.middle_finger;
    return JSON.stringify({ id, index_finger, middle_finger });
  }
}

let myReader = new Reader();

function showMessage(message_text, message_type = "error") {
  if (message_text != "") {
    let types = new Map();
    types.set("success", "success");
    types.set("error", "danger");
    let statusFieldID = myReader.currentStatusField;
    if (statusFieldID) {
      let statusField = document.getElementById(statusFieldID);
      statusField.innerHTML = `<div class="alert alert-${types.get(
        message_type
      )}">${message_text}</div>`;
    }
  }
}

function setReaderSelectField(fieldName) {
  myReader.readerSelectField(fieldName);
  myReader.displayReader();
}

function beginEnrollment() {
  setReaderSelectField("fp_reader");
  myReader.setStatusField("fp_status");
}

/**
 * @returns {boolean}
 */
function readyForEnroll() {
  return (
    document.getElementById("fp_user_id").value !== "" &&
    document.getElementById("fp_reader").value !== "Select Fingerprint Reader"
  );
}

function storeUserID() {
  let enrollUserId = document.getElementById("fp_user_id").value;
  myReader.currentHand.id = enrollUserId !== "" ? enrollUserId : 0;
}

/**
 * @returns {string}
 */
function getNextNotEnrolledID() {
  let indexFingers = document.getElementById("fp_indexfinger");
  let middleFingers = document.getElementById("fp_middlefinger");
  let enrollUserId = document.getElementById("fp_user_id").value;

  let indexFingerElement = findElementNotEnrolled(indexFingers);
  let middleFingerElement = findElementNotEnrolled(middleFingers);

  //assumption is that we will always start with
  //indexfinger and run down to middlefinger
  if (indexFingerElement !== null && enrollUserId !== "") {
    return indexFingerElement.id;
  }

  if (middleFingerElement !== null && enrollUserId !== "") {
    return middleFingerElement.id;
  }

  return "";
}

/**
 *
 * @param {Element} element
 * @returns {Element}
 */
function findElementNotEnrolled(element) {
  if (element) {
    for (let fingerElement of element.children) {
      if (fingerElement.firstElementChild.title === "not_enrolled") {
        return fingerElement;
      }
    }
  }

  return null;
}

function showNextNotEnrolledItem() {
  let nextElementID = getNextNotEnrolledID();
  let markup = null;
  if (
    nextElementID.startsWith("fp_index") ||
    nextElementID.startsWith("verification")
  ) {
    markup = `<span class="icon capture-indexfinger" title="not_enrolled"></span>`;
  }

  if (nextElementID.startsWith("fp_middle")) {
    markup = `<span class="icon capture-middlefinger" title="not_enrolled"></span>`;
  }

  if (nextElementID !== "" && markup) {
    let nextElement = document.getElementById(nextElementID);
    nextElement.innerHTML = markup;
  }
}

function beginCapture() {
  if (!readyForEnroll()) {
    return 0;
  }
  myReader.currentHand = new Hand();
  storeUserID(); // for current user in Hand instance
  myReader.reader.startCapture();
  showNextNotEnrolledItem();
}

function showSampleCaptured() {
  let nextElementID = getNextNotEnrolledID();
  let markup = null;
  if (
    nextElementID.startsWith("fp_index") ||
    nextElementID.startsWith("verification")
  ) {
    markup = `<span class="icon icon-indexfinger-enrolled" title="enrolled"></span>`;
  }

  if (nextElementID.startsWith("fp_middle")) {
    markup = `<span class="icon icon-middlefinger-enrolled" title="enrolled"></span>`;
  }

  if (nextElementID !== "" && markup) {
    let nextElement = document.getElementById(nextElementID);
    nextElement.innerHTML = markup;
  }
}

function storeSample(sample) {
  let samples = JSON.parse(sample.samples);
  let sampleData = samples[0].Data;

  let nextElementID = getNextNotEnrolledID();

  if (
    nextElementID.startsWith("fp_index") ||
    nextElementID.startsWith("verification")
  ) {
    myReader.currentHand.addIndexFingerSample(sampleData);
    showSampleCaptured();
    showNextNotEnrolledItem();
    return;
  }

  if (nextElementID.startsWith("fp_middle")) {
    myReader.currentHand.addMiddleFingerSample(sampleData);
    showSampleCaptured();
    showNextNotEnrolledItem();
  }
}

function clearCapture() {
  clearPrints();
  clearHand();
  myReader.reader.stopCapture();
}

function clearPrints() {
  let indexFingers = document.getElementById("fp_indexfinger");
  let middleFingers = document.getElementById("fp_middlefinger");

  if (indexFingers) {
    for (let indexfingerElement of indexFingers.children) {
      indexfingerElement.innerHTML = `<span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>`;
    }
  }

  if (middleFingers) {
    for (let middlefingerElement of middleFingers.children) {
      middlefingerElement.innerHTML = `<span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>`;
    }
  }
}

function clearHand() {
  myReader.currentHand = null;
}
