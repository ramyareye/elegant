<script>
  import Vue from 'vue'
  import { Picker } from 'emoji-mart-vue'
  import Editor from 'view/components/editor'
  import StickyScroll from 'vuestic-directives/StickyScroll'

  // const custom_plugin_submenu = {
  //       name: 'custom_plugin_submenu',

  //   // add function - It is called only once when the plugin is first run.
  //   // This function generates HTML to append and register the event.
  //   // arguments - (core : core object, targetElement : clicked button element)
  //   add: function (core, targetElement) {

  //       // Registering a namespace for caching as a plugin name in the context object
  //       const context = core.context;
  //       context.custom = {
  //           textElement: null
  //       };

  //       // Generate submenu HTML
  //       let listDiv = eval(this.setSubmenu(core.lang));

  //       // Input tag caching
  //       context.custom.textElement = listDiv.getElementsByTagName('INPUT')[0];

  //       // In addition to the button, elements that should operate within the submenu, such as focus,
  //       // must call stopPropagation in the mousedown event to prevent the toolbar from executing events.
  //       context.custom.textElement.addEventListener('mousedown', function (e) {
  //           e.stopPropagation();
  //       })

  //       // You must bind "core" object when registering an event.
  //       * add event listeners 
  //       listDiv.getElementsByTagName('BUTTON')[0].addEventListener('click', this.onClick.bind(core));
  //       context.custom.textElement.addEventListener('mousedown', function () {

  //       })

  //       /** append html */
  //       targetElement.parentNode.appendChild(listDiv);
  //   },

  //   setSubmenu: function (lang) {
  //       const listDiv = document.createElement('DIV');

  //       listDiv.className = 'layer_editor layer_align';
  //       listDiv.style.display = 'none';
  //       listDiv.innerHTML = '' +
  //           '<div class="inner_layer">' +
  //           '   <ul class="list_editor">' +
  //           '       <li><input type="text" style="width: 100%; border: 1px solid #CCC;" /></li>' +
  //           '       <li><button type="button" class="btn_editor" title="Append text">Append text</button></li>' +
  //           '   </ul>' +
  //           '</div>';

  //       return listDiv;
  //   },

  //   onClick: function () {
  //       // Get Input value
  //       const value = document.createTextNode(this.context.custom.textElement.value);

  //       // insert
  //       this.insertNode(value);

  //       // focus
  //       this.focus();
  //   }
  // }

  export default {
    name: 'chat',

    components: { Editor, Picker },

    directives: { StickyScroll },

    props: {
      value: {
        type: Array,
        default: () => []
      },
      attachments: {
        type: Array,
        default: () => []
      },
      height: {
        default: '20rem'
      },
      statuses: {
        type: Object,
        required: true
      },
      placeholder: {
        type: String,
        default: Vue.i18n.translate('custom.message_placeholder')
      },
      submitBtn: {
        type: String,
        default: Vue.i18n.translate('buttons.send')
      },
      updateBtn: {
        type: String,
        default: Vue.i18n.translate('buttons.update')
      }
    },

    data () {
      return {
        text: '',
        status: 'inProgress',
        editor: null,
        showEmojies: false,
        update: false,
        updateId: 0
      //   buttons: [
      //     {
      //       // plugin's name attribute
      //       name: 'custom_plugin_submenu', 
      //       // name of the plugin to be recognized by the toolbar.
      //       // It must be the same as the name attribute of the plugin 
      //       dataCommand: 'custom_plugin_submenu',
      //       // button's class ("btn_editor" class is registered, basic button click css is applied.)
      //       // ** If you want to enable it even in code view mode, add a "code-view-enabled" class **
      //       buttonClass:'btn_editor', 
      //       // HTML title attribute
      //       title:'Custom plugin of the submenu', 
      //       // 'submenu' or 'dialog' or '' (command button)
      //       dataDisplay:'submenu',
      //       // 'full' or '' (Only applies to dialog plugin.)
      //       displayOption:'',
      //       // HTML to be append to button
      //       innerHTML:'<div class="icon-map-pin"></div>'
      //     }
      //   ]
      }
    },

    methods: {
      handleEditor (editor) {
        this.editor = editor
      },

      // keyHandler (e) {
        // if (e.keyCode === 13) {
        //   this.sendMessage()
        // } else {
          // document.getElementById('foobar').addEventListener('keyup', e => {
            // console.log('Caret at: ', e.target.selectionStart)
          // })
        // }
      // },

      sendMessage () {

        if (this.editor.getContents() !== '' && this.status) {
          const data = {
            status: this.status,
            text: this.editor.getContents()
          }

          if (this.update) {
            data.updateId = this.updateId

            this.$emit('update', data)
          } else {
            this.$emit('input', data)
          }          
        } else {
          this.$store.dispatch('addToastMessage',
            { text: 'Message or Status is empty!' }
          )
        }
      },
      deleteMessage () {
          this.$emit('delete', this.updateId)
      },
      clear () {
        this.status = ''
        this.updateId = 0
        this.update = false
        this.editor.setContents('')
      },
      addEmoji (e) {
        this.editor.appendContents(e.native)
      },
      toggleEmojies () {
        this.showEmojies = !this.showEmojies
      },
      onChangeStatus (id) {
        this.status = id
      },
      editMsg (index) {
        const value = this.value[index]

        this.update = true
        this.updateId = value.id
        this.status = value.status
        this.editor.setContents(value.text)
      },
      renderStatus (status) {
        for (let [key, value] of Object.entries(this.statuses)) {
          if (status === key) {
            return value
          }
        }
      },
      isAttachmentImg (ext) {
        if (['jpg', 'jpeg', 'gif', 'png'].includes(ext)) {
          return true
        }

        return false
      }
    },

    computed: {
      possibleStatuses () {
        let statuses = []
        const notInList = ['askedByUser', 'repliedByUser' ,'repliedByDoctor']

        for (let [key, value] of Object.entries(this.statuses)) {
          if (!notInList.includes(key)) {
            statuses.push({
              id: key,
              title: value
            })
          }
        }

        return statuses
      }
    }
  }
</script>

<template>
 <div class="vuestic-chat">
   <div class="chat-body" :style="{'height': height}" v-sticky-scroll="{animate: true, duration: 500}">
     <div       
       class="chat-message"
       v-for="(message, index) in value"
       :key="index"
       :class="{'yours': message.yours, 'alien': !message.yours}"       
     >
      <p>
        نویسنده :‌ {{ message.writer.name }} 
        <span>
          تاریخ : {{ message.date }} - {{ message.time }}
          <span v-if="message.yours">
            <i class="glyphicon glyphicon-pencil" @click="editMsg(index)"></i>
          </span>
          <br/>
          <span style="float: left;" v-html="renderStatus(message.status)"></span>
        </span>
      </p> 
      <div v-html="message.text"></div>      
     </div>
     <div v-if="!value.length" class="text-center mt-3">{{ $t('consult.no_answer') }}</div>
   </div>
   <div class="chat-controls">
      <div class="row mt-2">
        <Editor @editor="handleEditor" :mode="'classic'" />
      </div>
      <div class="row row-reverse mt-2">
        <div class="col-7">
          <div class="vuestic-radio-button form-check radio abc-radio" v-for="st in possibleStatuses" @click="onChangeStatus(st.id)"> 
            <input class="form-check-input" type="radio" :value="st.id" :checked="st.id === status">
            <label class="form-check-label" :for="st.id">
              <span class="abc-label-text">{{ st.title }}</span>
            </label>
          </div>
        </div>

        <div class="col-5">
          <fieldset>
            <div class="form-group form-group-w-btn">
              <div class="input-group btn-area">
                <div>
                  <picker 
                    v-show="showEmojies"
                    @select="addEmoji"  
                    :style="{ position: 'absolute', bottom: '180px', left: '50px' }" 
                  />
                  <span @click="toggleEmojies" style="cursor: pointer;float: right;">👍</span>                
                </div>
                <div class="btn btn-sm btn-primary btn-micro" @click="sendMessage()">
                  {{ update ? updateBtn : submitBtn }}
                </div>
                <div class="btn btn-sm btn-warning btn-micro" @click="clear" v-if="update">بیخیال</div>
                <div class="btn btn-sm btn-danger btn-micro" @click="deleteMessage" v-if="update">حذف</div>
                <!-- <input @keypress="keyHandler($event)" v-model="text" required title=""/> -->
                <!-- <label class="control-label">{{ placeholder }}</label><i class="bar"></i> -->                
              </div> 
            </div>
          </fieldset>
        </div>

        <div class="col-4" v-for="a in attachments">
          <a :href="a.file" target="_blank" style="display: block;">
            <img v-if="isAttachmentImg(a.ext)" :src="a.file" style="max-width: 100%;"/>
            <img v-else :src="require(`assets/icons/${a.ext}.svg`)" style="max-width: 100%;"/>
          </a>
        </div>
      </div>      
   </div>
 </div>
</template>

<style lang='scss' scoped>
  $chat-body-min-height: 18.75rem;
  $chat-body-mb: 1.5rem;
  $chat-message-mb: 0.625rem;
  $chat-message-py: 0.657rem;
  $chat-message-px: 1.375rem;
  $chat-message-br: 0.875rem;

  .vuestic-chat {
    width: 100%;
  }

  .chat-body {
    min-height: $chat-body-min-height;
    display: flex;
    flex-direction: column;
    margin-bottom: $chat-body-mb;
    overflow: auto;
  }

  .chat-message {
    padding: $chat-message-py $chat-message-px;
    margin-bottom: $chat-message-mb;
    border-radius: $chat-message-br;
    min-width: 50%;
    max-width: 75%;
    overflow-wrap: break-word;

    &:last-child {
      margin-bottom: 0;
    }

    &.alien {
      align-self: flex-start;
      border-top-left-radius: 0;
      background-color: $light-gray2;
    }

    &.yours {
      align-self: flex-end;
      border-top-right-radius: 0;
      background-color: $brand-primary;
    }

    .chat-message-input {
      resize: vertical !important;
    }

    p span {
      float: left;
    }
  }

  .emoji-mart {
    z-index: 100000;
  }

  .sun-editor .sun-editor-id-editorArea {
    min-height: 100px !important;
  }

  .btn-area {
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;

  }

  .btn-area > div {
    align-self: center !important;
    margin-bottom: 10px;
  }

  .swal2-container.swal2-shown {
    z-index: 10000;
  }

  .chat-controls {
    max-width: 500px;
    margin: auto;
  }

  .chat-controls .row.row-reverse > .col-4 {
    max-height: 150px;
    overflow: hidden;
  }

  @media (max-width: 500px) {
    .chat-controls {
      width: 100%;
      max-width: 100%;
      margin: auto;
    }
  }

</style>
