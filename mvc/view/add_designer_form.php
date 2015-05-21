<form class="form-horizontal" method="post" enctype="multipart/form-data" action="add_designer.php?action=submit">
    <fieldset>
    <div class="control-group">
          <!-- Text input-->
          <label class="control-label" for="input01">姓名:</label>
          <div class="controls">
            <input name="name" id="name" type="text" placeholder="" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">年龄:</label>
          <div class="controls">
            <input name="age" id="age" type="text" placeholder="" class="input-xlarge" onkeyup="validate_age()">
            <p class="help-block"></p>
          </div>
        </div>
    <div class="control-group">
          <label class="control-label">性别:</label>
          <div class="controls">
      <!-- Inline Radios -->
      <label class="radio inline">
        <input type="radio" value="0" name="gender_group" checked="checked">
        男
      </label>
      <label class="radio inline">
        <input type="radio" value="1" name="gender_group">
        女
      </label>
  </div>
        </div>

    <div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">称号:</label>
          <div class="controls">
            <select class="input-xlarge" name="type">
      <option value='0'>无</option>
      <option value='1'>首席设计师</option>
      <option value='2'>主任设计师</option>
      <option value='3'>百强设计师</option>
      <option value='4'>精品设计师</option>
            </select>
          </div>

        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">手机号:</label>
          <div class="controls">
            <input name="phone" id="phone" type="text" placeholder="" class="input-xlarge" onkeyup="validate_age()">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">头像:</label>

          <!-- File Upload -->
          <div class="controls">
            <input name="head_image" id="head_image" class="input-file" type="file">
            <p class="help-block">图片格式: png或jpeg，大小: 200px*200px</p>
          </div>
        </div>

    <div class="control-group">

          <!-- Textarea -->
          <label class="control-label">介绍:</label>
          <div class="controls">
            <div class="textarea">
                  <textarea name="desc" id="desc" type="" class="" style="margin: 0px; height: 148px; width: 271px; resize: none;"> </textarea>
            </div>
          </div>
        </div>
            <div class="control-group">

          <!-- Textarea -->
          <label class="control-label"></label>
          <div class="controls">
            <div class="textarea">
                  <input type="submit" id="add_designer_button" value="添加">
            </div>
          </div>
        </div>
    </fieldset>
  </form>