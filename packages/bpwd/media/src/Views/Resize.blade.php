<div class="container">
  <div class="row fill">
    <div class="col-md-8 fill" id="containment">
      <img id="resize" src="{{ asset($img) }}" height="{{ $height }}" width="{{ $width }}">
    </div>
    <div class="col-md-4 fill">

      <table class="table table-compact table-striped">
        <thead></thead>
        <tbody>
          @if ($scaled)
          <tr>
            <td>Ratio:</td>
            <td>{{ number_format($ratio, 2) }}</td>
          </tr>
          <tr>
            <td>Image scaled:</td>
            <td>
              Yes
            </td>
          </tr>
          @endif
          <tr>
            <td>Original Height:</td>
            <td>{{ $original_height }}px</td>
          </tr>
          <tr>
            <td>Original Width:</td>
            <td>{{ $original_width }}px</td>
          </tr>
          <tr>
            <td>Height:</td>
            <td><span id="height_display"></span></td>
          </tr>
          <tr>
            <td>Width:</td>
            <td><span id="width_display"></span></td>
          </tr>
        </tbody>
      </table>

      <button class="btn btn-primary" onclick="doResize()">Resize</button>
      <button class="btn btn-info" onclick="loadItems()">Cancel</button>

      <input type="hidden" name="ratio" value="{{ $ratio }}"><br>
      <input type="hidden" name="scaled" value="{{ $scaled }}"><br>
      <input type="hidden" id="original_height" name="original_height" value="{{ $original_height }}"><br>
      <input type="hidden" id="original_width" name="original_width" value="{{ $original_width }}"><br>
      <input type="hidden" id="height" name="height" value=""><br>
      <input type="hidden" id="width" name="width">

    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $("#height_display").html($("#resize").height() + "px");
    $("#width_display").html($("#resize").width() + "px");

    $("#resize").resizable({
      aspectRatio: true,
      containment: "#containment",
      handles: "n, e, s, w, se, sw, ne, nw",
      resize: function (event, ui) {
        $("#width").val($("#resize").width());
        $("#height").val($("#resize").height());
        $("#height_display").html($("#resize").height() + "px");
        $("#width_display").html($("#resize").width() + "px");
      }
    });
  });

  function doResize() {
    $.ajax({
      type: "GET",
      dataType: "text",
      url: "{{ route('media.manager.performResize') }}",
      data: {
        img: '{{ $img }}',
        working_dir: $("#working_dir").val(),
        dataX: $("#dataX").val(),
        dataY: $("#dataY").val(),
        dataHeight: $("#height").val(),
        dataWidth: $("#width").val()
      },
      cache: false
    }).done(function (data) {
      if (data == "OK") {
        loadItems();
      } else {
        notify(data);
      }
    });
  }
</script>
