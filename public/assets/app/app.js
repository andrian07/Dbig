function _initTooltip() {
  if ($('[data-toggle="tooltip"]').length) {
    $('[data-toggle="tooltip"]').tooltip();
  }
}

let select2Delay = 1000;

let configModal = {
  keyboard: true,
  backdrop: "static",
  show: true,
};

let configMargin = {
  currencySymbol: "%",
  currencySymbolPlacement: "s",
  digitGroupSeparator: THOUSAND_SEPARATOR,
  decimalCharacter: DECIMAL_SEPARATOR,
  maximumValue: "999",
  minimumValue: "-999",
  modifyValueOnWheel: AutoNumeric.options.modifyValueOnWheel.doNothing,
};

let configDisc = {
  currencySymbol: "%",
  currencySymbolPlacement: "s",
  digitGroupSeparator: THOUSAND_SEPARATOR,
  decimalCharacter: DECIMAL_SEPARATOR,
  maximumValue: "100",
  minimumValue: "0",
  modifyValueOnWheel: AutoNumeric.options.modifyValueOnWheel.doNothing,
};

let configQty = {
  currencySymbol: "",
  currencySymbolPlacement: "s",
  digitGroupSeparator: THOUSAND_SEPARATOR,
  decimalCharacter: DECIMAL_SEPARATOR,
  maximumValue: "99999",
  minimumValue: "-99999",
  modifyValueOnWheel: AutoNumeric.options.modifyValueOnWheel.doNothing,
};

let configPoint = {
  currencySymbol: "",
  currencySymbolPlacement: "s",
  digitGroupSeparator: THOUSAND_SEPARATOR,
  decimalCharacter: DECIMAL_SEPARATOR,
  maximumValue: "999999999",
  minimumValue: "0",
  modifyValueOnWheel: AutoNumeric.options.modifyValueOnWheel.doNothing,
};

let configRp = {
  currencySymbol: "Rp ",
  digitGroupSeparator: THOUSAND_SEPARATOR,
  decimalCharacter: DECIMAL_SEPARATOR,
  maximumValue: "99999999999",
  minimumValue: "-99999999999",
  modifyValueOnWheel: AutoNumeric.options.modifyValueOnWheel.doNothing,
};

let htmlEntities = {
  entities: [
    ["amp", "&"],
    ["apos", "'"],
    ["#x27", "'"],
    ["#x2F", "/"],
    ["#39", "'"],
    ["#47", "/"],
    ["lt", "<"],
    ["gt", ">"],
    ["nbsp", " "],
    ["quot", '"'],
    ["#039", "'"],
  ],
  encode: function (text = "") {
    const entities = this.entities;
    for (var i = 0, max = entities.length; i < max; ++i)
      text = text.replaceAll(entities[i][1], "&" + entities[i][0] + ";");
    return text;
  },
  decode: function (text = "") {
    const entities = this.entities;
    for (var i = 0, max = entities.length; i < max; ++i)
      text = text.replaceAll(
        new RegExp("&" + entities[i][0] + ";", "g"),
        entities[i][1]
      );

    return text;
  },
};

// Configs //
let select2_delay = 1000;

// user role  helper //
function getRoleVal(src, key, role_val) {
  let roleIndex = Object.keys(src).indexOf(key);
  if (roleIndex >= 0) {
    let roleVal = Object.keys(src)[roleIndex];
    return src[roleVal];
  } else {
    return role_val;
  }
}

function hasRole(line) {
  let tempSrc = user_role;
  let segments = line.split(".");
  let role_val = 0;

  segments.forEach((key) => {
    let getRole = getRoleVal(tempSrc, key, role_val);
    if (typeof getRole === "object") {
      tempSrc = getRole;
    } else {
      role_val = getRole;
    }
  });

  if (role_val == 1) {
    return true;
  } else {
    return false;
  }
}

// Toast Helper //
let notificationDelay = 10000;
let notification = {
  success: function (_message, _title = "Info") {
    $(document).Toasts("create", {
      autohide: true,
      delay: notificationDelay,
      class: "bg-success",
      title: _title,
      subtitle: "",
      body: _message,
    });
  },
  info: function (_message, _title = "Info") {
    $(document).Toasts("create", {
      autohide: true,
      delay: notificationDelay,
      class: "bg-info",
      title: _title,
      subtitle: "",
      body: _message,
    });
  },
  warning: function (_message, _title = "Info") {
    $(document).Toasts("create", {
      autohide: true,
      delay: notificationDelay,
      class: "bg-warning",
      title: _title,
      subtitle: "",
      body: _message,
    });
  },
  danger: function (_message, _title = "Info") {
    $(document).Toasts("create", {
      autohide: true,
      delay: notificationDelay,
      class: "bg-danger",
      title: _title,
      subtitle: "",
      body: _message,
    });
  },
};

// Sweatalert Helper //
const buttons = {
  yes: "Ya",
  no: "Tidak",
  cancel: "Batal",
};

let parseMessageResult = function (result) {
  if (result.isConfirmed) {
    return true;
  } else if (result.isDenied) {
    return false;
  }
  return false;
};

let message = {
  success: function (_message, _title = "Info") {
    return Swal.fire({
      title: _title,
      html: _message,
      allowOutsideClick: false,
      icon: "success",
    });
  },
  info: function (_message, _title = "Info") {
    return Swal.fire({
      title: _title,
      html: _message,
      allowOutsideClick: false,
      icon: "info",
    });
  },
  warning: function (_message, _title = "Peringatan") {
    return Swal.fire({
      title: _title,
      html: _message,
      icon: "warning",
      showCancelButton: true,
      allowOutsideClick: false,
      cancelButtonColor: "#d33",
      confirmButtonText: buttons.yes,
      cancelButtonText: buttons.cancel,
    });
  },
  question: function (_message, _title = "Konfirmasi") {
    return Swal.fire({
      title: _title,
      html: _message,
      icon: "question",
      showCancelButton: true,
      allowOutsideClick: false,
      cancelButtonColor: "#d33",
      confirmButtonText: buttons.yes,
      cancelButtonText: buttons.cancel,
    });
  },
  error: function (_message, _title = "Error") {
    return Swal.fire({
      title: _title,
      html: _message,
      icon: "error",
      allowOutsideClick: false,
    });
  },
};

// Select2 Helper //
function setSelect2(select_name = "", svalue = "", slabel = "") {
  $(select_name).empty();
  if (!(svalue == "" || slabel == "")) {
    $(select_name).append(
      '<option selected value="' + svalue + '">' + slabel + "</option>"
    );
    $(select_name).select2("data", {
      id: svalue,
      label: slabel,
    });
    $(select_name).trigger("change");
  } else {
    if (typeof svalue == "object") {
      svalue.forEach(function (val, i) {
        $(select_name).append(
          '<option selected value="' + val.id + '">' + val.label + "</option>"
        );
      });
      $(select_name).select2("data", svalue);
      $(select_name).trigger("change");
    }
  }
}

function setSelect2Multiple(select_name = "", aDatasource = Array()) {
  $(select_name).empty();

  $.each(aDatasource, function (key, val) {
    $(select_name).append(
      '<option selected value="' + val.id + '">' + val.text + "</option>"
    );
  });
  $(select_name).select2("data", aDatasource);
  $(select_name).trigger("change");
}

// loader Helper //
let useLoader = true;
let loader = {
  start: function () {
    if (useLoader) {
      const start_text = "Harap Tunggu";
      $("body")
        .loadingModal({ text: start_text })
        .loadingModal("color", "white")
        .loadingModal("animation", "chasingDots")
        .loadingModal("backgroundColor", "gray")
        .loadingModal("text", start_text);
    }
  },
  stop: function () {
    if (useLoader) {
      const stop_text = "Selesai";
      $("body").loadingModal("text", stop_text);
      $("body").loadingModal("hide").loadingModal("destroy");
    }
  },
};

// Ajax Helper //
const ajaxErrorText =
  "Terjadi kesalahan dalam menjalankan perintah. Harap coba lagi";

function printError(error, explicit) {
  let print = `[${explicit ? "EXPLICIT" : "INEXPLICIT"}] ${error.name}: ${
    error.message
  }`;
  console.log(print);
  return print;
}

function parseJSON(json_val) {
  let parse;
  let is_json;
  let error;
  try {
    parse = JSON.parse(json_val);
    is_json = true;
    error = "";
  } catch (e) {
    parse = JSON.parse("{}");
    is_json = false;
    if (e instanceof SyntaxError) {
      error = printError(e, true);
    } else {
      error = printError(e, false);
    }
  }
  return [parse, is_json, error];
}

function ajax_get(_url, _data = null, _callback = {}, _async = true) {
  let results = { success: false, result: {} };
  $.ajax({
    url: _url,
    data: _data,
    async: _async,
    beforeSend: function () {
      if (typeof _callback.beforeSend === "function") {
        _callback.beforeSend();
      }
      loader.start();
    },
    success: function (request_results) {
      loader.stop();
      let [json, is_json, error] = parseJSON(request_results);
      results = {
        success: true,
        result: json,
      };
      if (typeof _callback.success === "function") {
        _callback.success(results);
      }
    },
    error: function () {
      loader.stop();
      results = {
        success: false,
        result: {},
      };
      message.error(ajaxErrorText);
      if (typeof _callback.error === "function") {
        _callback.error(results);
      }
    },
    complete: function () {
      loader.stop();
      if (typeof _callback.complete === "function") {
        _callback.complete();
      }
    },
  });
  return results;
}

function ajax_post(
  _url,
  _data = null,
  _callback = {},
  _async = true,
  _uploadFile = false
) {
  // formData Format :
  // let form_data = new FormData();
  // form_data.append("photo", file.files[0]);

  let results = { success: false, result: {} };

  if (_uploadFile) {
    $.ajax({
      url: _url,
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfHash,
      },
      processData: false,
      contentType: false,
      data: _data,
      async: _async,
      beforeSend: function () {
        if (typeof _callback.beforeSend === "function") {
          _callback.beforeSend();
        }
        loader.start();
      },
      success: function (request_results) {
        loader.stop();
        let [json, is_json, error] = parseJSON(request_results);
        results = {
          success: true,
          result: json,
        };

        if (typeof json.csrfHash == "string") {
          csrfHash = json.csrfHash;
        }

        if (typeof _callback.success === "function") {
          _callback.success(results);
        }
      },
      error: function (x, status, error) {
        loader.stop();
        results = {
          success: false,
          result: {},
        };

        message.error(ajaxErrorText);
        if (typeof _callback.error === "function") {
          _callback.error(results);
        }
        if (x.status == 403) {
          location.reload();
        }
      },
      complete: function () {
        loader.stop();
        if (typeof _callback.complete === "function") {
          _callback.complete();
        }
      },
    });
  } else {
    $.ajax({
      url: _url,
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfHash,
      },
      data: _data,
      async: _async,
      beforeSend: function () {
        if (typeof _callback.beforeSend === "function") {
          _callback.beforeSend();
        }
        loader.start();
      },
      success: function (request_results) {
        loader.stop();
        let [json, is_json, error] = parseJSON(request_results);
        results = {
          success: true,
          result: json,
        };

        if (typeof json.csrfHash == "string") {
          csrfHash = json.csrfHash;
        }

        if (typeof _callback.success === "function") {
          _callback.success(results);
        }
      },
      error: function (x, status, error) {
        loader.stop();
        results = {
          success: false,
          result: {},
        };

        message.error(ajaxErrorText);
        if (typeof _callback.error === "function") {
          _callback.error(results);
        }
        if (x.status == 403) {
          location.reload();
        }
      },
      complete: function () {
        loader.stop();
        if (typeof _callback.complete === "function") {
          _callback.complete();
        }
      },
    });
  }
  return results;
}

function numberFormat(value, show_decimal = false) {
  let number = 0;
  let number_prefix = "";
  if (typeof value == "string") {
    value = parseFloat(value);
  }

  if (value < 0) {
    number_prefix = "-";
    value = Math.abs(value);
  }

  if (show_decimal) {
    number = value.toFixed(DECIMAL_DIGIT);
  } else {
    number = value.toFixed(0);
  }

  let number_string = number.toString(),
    split = number_string.split("."),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

  if (ribuan) {
    separator = sisa ? THOUSAND_SEPARATOR : "";
    rupiah += separator + ribuan.join(THOUSAND_SEPARATOR);
  }
  return split[1] != undefined
    ? number_prefix + rupiah + DECIMAL_SEPARATOR + split[1]
    : number_prefix + rupiah;
}

$(document).ready(function () {
  _initTooltip();

  $("#btnlogout").click((e) => {
    e.preventDefault();
    let question = $("#btnlogout").attr("data-question");
    let url = $("#btnlogout").attr("href");
    message.question(question).then((answer) => {
      let yes = parseMessageResult(answer);
      if (yes) {
        window.location.href = url;
      }
    });
  });
});
