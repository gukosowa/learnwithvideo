<template>
  <div class="bg-gray-900 text-white flex flex-grow" style="background-image: linear-gradient(-31deg, rgb(29, 33, 37) 0%, rgb(32, 41, 56) 100%);">
    <!-- container -->
    <div class="container max-w-3xl">
      <div class="home flex flex-col">

        <!-- Video container -->
        <div ref="container" class="video-container shadow-lg border rounded-lg overflow-hidden border-gray-900 flex flex-col mt-10 z-10">
            <youtube class="self-center w-full z-0" 
                player-width="100%"
                :player-vars="{ autoplay: 1, controls: 0, showinfo: 0, cc_load_policy: 0, cc_lang_pref:'en', wmode:'transparent' }" 
                :video-id="url"
                @ready="ready" 
                @paused="pause" 
                @playing="playing"
            ></youtube>
            <div class="bg-black">
                <div class="bg-gray-700 w-full h-1" v-bind:style="{ width: progress + '%' }"></div>
            </div>
        </div>

        <!-- Text selection overlay -->
        <div v-show="showHighlightText"  @mouseover="pause" @mouseleave="play" class="highlightMenu rounded-lg bg-gray-900 py-3 px-2 z-50 absolute" style="transform: translate(-50%, -100%);" :style="{ left: `${xHighlightMenu}px`, top: `${yHighlightMenu}px` }" @mousedown.prevent="">
            <span class="mr-2 p-3 cursor-pointer" @mousedown.prevent="getDefinition">
                Add Word
            </span>
            <!-- <span class="ml-2" @mousedown.prevent="handleAction('highlight')">
                Highlight
            </span> -->
            <!-- You can add more buttons here -->
        </div>

        <!-- CONTENT -->
        <div @mousedown="deselectDialogue" @mouseover="pause" @mouseleave="play" class="-mt-3 mx-3 p-6 py-12 bg-gray-800 h-48 shadow-lg border rounded-lg border-gray-900 flex flex-col mt-10 z-0" style="background-color: #283243;">
            <div ref="dialogueField" class="text-4xl text-center">
                {{ editText }}
            </div>
        </div>

        <!-- Controlls -->
        <div class="flex flex-col shadow-lg bottom-0 absolute mb-5 p-4 rounded-lg z-20 self-center" style="background-color: #0f1218;">

          <!-- Edit controlls -->
          <div @mousedown="timeLineClick" class="flex flex-col">
                <div class="flex items-center w-full mb-1">
                    <div class="w-full flex flex-row">

                    <!-- Insert button -->
                    <button @click="addEmptyDialogue" class="bg-gray-700 w-6 mr-3 hover:bg-gray-600 text-white font-bold py-2 px-2 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                        *
                    </button>

                    <!-- Insert button -->
                    <button @click="saveDialogue" 
                    class="bg-gray-700 w-32 mr-3 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none"
                    :class="{ 'bg-red-500 hover:bg-red-600 border-red-800' : editTextDirty }">
                        Save text
                    </button>

                    <!-- dialogue text -->
                    <input 
                    v-model="editText"
                    @input="changeEditText"
                    class="bg-gray-300 w-full appearance-none border-2 border-gray-300 rounded w-full py-2 px-4 text-gray-900 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                    id="inline-full-name" 
                    type="text" 
                    value="鳥の絡まるぼろる長屋、ひたすら. 筆走る"
                    autocomplete="off"
                    placeholder="Dialogue here">
                    </div>
                </div>

                <!-- timeline -->
                <vue-slider
                class="mt-2"
                v-model="currentTime"
                tooltip="always" tooltipPlacement="right"
                width="100%"
                height="0.9rem"
                :lazy="false"
                :duration="0"
                :min="0"
                :interval="0.1"
                :max="durationTime"
                :tooltip-formatter="timeFormater"
                :process="false"
                @change="changeCurrentTime"
                ></vue-slider>

                <!-- editor timeline -->
                <vue-slider 
                class="mb-1"
                v-model="timeline" 
                height="1.2rem"
                :enable-cross="false"
                :dotSize="18"
                @change="timeLineRelease" 
                :duration="0"
                :min="0" 
                :interval="0.1" 
                :max="durationTime" 
                :process="hightlightCurrentDialogue"
                :tooltip-formatter="timeFormater"
                tooltipPlacement="bottom"
                width="100%"
                :lazy="true"></vue-slider>
            </div>

            <!-- normal controlls -->
            <div class="flex flex-row items-center">
                <!-- play button -->
                <button @click="togglePlay" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                    Play
                </button>

            <!-- next/ prev dialogue -->
            <div class="inline-flex ml-5">
                <button @click="jumpPrevious" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded-l focus:outline-none">
                    Prev
                </button>
                <button @click="jumpNext" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded-r focus:outline-none">
                    Next
                </button>
            </div>

            <!-- time slider -->
            <div class="w-3/4 mx-5 relative">
                <vue-slider 
                    v-model="currentTime"
                    tooltip="focus" tooltipPlacement="top"
                    width="333px"
                    height="0.9rem"
                    :lazy="true"
                    :duration="0"
                    :min="0"
                    :interval="0.1"
                    :max="durationTime"
                    :tooltip-formatter="timeFormater"
                    @change="changeCurrentTime"
                ></vue-slider>
            </div>

            <!-- time as text -->
            <span class="text-sm w-32 text-center">{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
import gql from 'graphql-tag'

export default {
    name: 'home',
    components: {
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    data () {
        return {
            editText: "",
            currentTime: 0,
            progress: 0,
            processId: null,
            duration: 1,
            url: "V6ZfH28jU28",
            paused: false,
            timeline: [8.1, 18.2, 31, 37.7, 41.4, 44.7, 51.1, 58, 63.3],
            dialogue: [
            "鳥の絡まるぼろる長屋、ひたすら. 筆走る", 
            "宵待草がささやいた、駆け出すえどのまち。", 
            "月夜の浮世に小道、真の画工となるべし",
            "夢叶うなら人魂で",
            "行く気散じや夏の原",
            "歌い世に響く、三味の音",
            "北から涼風が穂を揺らす",
            "写る月の影が弧を描き",
            "今主役はおいら江戸錦"],
            cachedTimeline: [],
            cacheCurrentDialogueId: -1,
            dialogueId: 0,
            timeFormater: v => `${this.formatTime(v)}`,
            // eslint-disable-next-line
            hightlightCurrentDialogue: b => [
                [this.timeline[this.dialogueId]*1.35, (!this.timeline[this.dialogueId+1]) ? this.duration : (this.timeline[this.dialogueId+1]*1.37), { backgroundColor: 'red' }],
            ],
            editTextDirty: false,

            xHighlightMenu: 0,
            yHighlightMenu: 0,
            showHighlightText: false,
            selectedText: "",
            wordTable: [{vocab_id:1, start_pos:0, dialogue_id:0, word:"鳥", custom_info:"fgf"}],
            word: {},
        }
    },

    apollo: {
        // Query with parameters
        word: {
            // gql query
            query: gql`query WordGet($id: Int!) {
                word(id: $id) {
                    definition {
                        word
                    }
                }
                
            }`,
            // Static parameters
            variables: {
                id: '1',
            },
        },
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    computed: {
        //#####################################################
        //
        //
        durationTime() {
            return Math.round(this.duration);
        },

        //#####################################################
        //
        //
        highlightableEl () {
            return this.$refs.dialogueField
        }
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    mounted () {
        window.addEventListener('mouseup', this.onMouseup);
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    beforeDestroy () {
        window.removeEventListener('mouseup', this.onMouseup)
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    methods: {
        //#####################################################
        //
        //
        getDefinition() {
            // GET request for remote image
            const baseURI = 'http://localhost:8000/api/definition';
            this.$http.get(baseURI).then((result) => {
                console.log(result);
            })
        },

        //#####################################################
        //
        //
        changeEditText() {
            this.editTextDirty = true;
        },

        //#####################################################
        //
        //
        timeLineClick() {
            this.cachedTimeline = this.timeline;
            console.log("cache timeline to cachedTimeline");
            
            this.deselectDialogue();
        },

        //#####################################################
        //
        //
        timeLineRelease() {
            // this.changeCurrentTime(this.diffArray(this.cachedTimeline, this.timeline)[1]);
            console.log("check difference and change the time");
            this.timeline = this.timeline.sort(function(a, b){return a - b});
            this.cachedTimeline = this.timeline;

            // Update the current dialogue shown
            this.updateShowDialogue();
        },

        //#####################################################
        //
        //
        setNewVideo (url) {
            this.videoId = this.$youtube.getIdFromURL(url)
            this.startTime = this.$youtube.getTimeFromURL(url)
        },

        //#####################################################
        //
        //
        ready (event) {
            console.log("ready video", event);
            this.player = event.target

            // this.timeline.push(this.player.getDuration());
            // var frames = document.getElementsByTagName("iframe");
            // for (var i = 0; i < frames.length; i++) {
            //   frames[i].src += "?wmode=transparent";
            // }
        },

        //#####################################################
        //
        //
        change () {
            // when you change the value, the player will also change.
            // If you would like to change `playerVars`, please change it before you change `videoId`.
            // If `playerVars.autoplay` is 1, `loadVideoById` will be called.
            // If `playerVars.autoplay` is 0, `cueVideoById` will be called.
            this.videoId = 'another video id'
        },

        //#####################################################
        //
        //
        addDialogue(customText) {
            let text = this.editText;
            if (customText == "") {
                text = customText;
            }
            var i;
            let added = false;
            for(i=0;i<this.timeline.length;i++) {
                if (this.timeline[i] > this.currentTime) {
                this.dialogue.splice(i, 0, text);
                this.timeline.splice(i, 0, parseFloat(this.currentTime.toFixed(2)));
                added = true;
                break;
                }
            }

            if (!added) {
                this.dialogue.push(text);
                this.timeline.push(this.currentTime.toFixed(2));
            }

            this.timeline = this.timeline.sort(function(a, b){return a - b});
            console.log("did sort", this.timeline);
            this.cachedTimeline = this.timeline;

            this.changeCurrentTime(this.currentTime + 0.2);
            this.cacheCurrentDialogueId = -1;
        },

        //#####################################################
        //
        //
        addEmptyDialogue() {
            // this.pause();
            this.addDialogue("");
        },

        //#####################################################
        //
        //
        saveDialogue() {
            if (this.editTextDirty) {
                this.dialogue[this.dialogueId] = this.editText;
                this.editTextDirty = false;
            }
        },

        //#####################################################
        //
        //
        jumpNext() {
            if (this.currentTime >= this.timeline.slice(-1)[0]) {
                return;
            }

            if (this.currentTime < this.timeline[0]) {
                this.changeCurrentTime(this.timeline[0] + 0.01);
            } else {
                this.dialogueId += 1;
            }

            if (this.dialogueId > this.timeline.length-1) {
                this.dialogueId = this.timeline.length-1;
            }
            this.changeCurrentTime(this.timeline[this.dialogueId] + 0.01);

            this.updateShowDialogue();
        },

        //#####################################################
        //
        //
        jumpPrevious() {
            let prevTolerance = 1;
            if (Math.abs(this.currentTime-this.timeline[this.dialogueId]) <= prevTolerance || (this.dialogueId == 0 && this.currentTime < this.timeline[0] + prevTolerance)) {
                this.dialogueId -= 1;
            }
            if (this.dialogueId < 0) {
                this.dialogueId = 0;
                this.changeCurrentTime(0);
            } else {
                this.changeCurrentTime(this.timeline[this.dialogueId] + 0.01);
            }
            this.updateShowDialogue();
        },

        //#####################################################
        //
        //
        changeCurrentTime(time) {
            this.player.seekTo(time);
            this.updateShowDialogue();
        },

        //#####################################################
        //
        //
        // eslint-disable-next-line
        async playing(event) {
            let totalTime = await this.player.getDuration();
            this.duration = totalTime;

            this.processId = setInterval(() => {
                if (this.player) {
                    this.currentTime = this.player.getCurrentTime();

                    let progress = (this.currentTime / totalTime) * 100;
                    this.progress = progress < 100 ? progress : 100;

                    // Update the current dialogue shown
                    this.updateShowDialogue();
                }
            }, 150);
        },

        //#####################################################
        //
        //
        updateShowDialogue() {
            this.currentTime = this.player.getCurrentTime();
            for(var i = 0;i < this.timeline.length; i++) {
                if (this.currentTime > this.timeline[i]) {
                    this.dialogueId = i;
                }
            }
            if (this.cacheCurrentDialogueId != this.dialogueId) {
                this.deselectDialogue();
                this.editTextDirty = false;
                this.editText = this.dialogue[this.dialogueId];
                this.cacheCurrentDialogueId = this.dialogueId;
            }
        },

        //#####################################################
        //
        //
        formatTime(time) {
            time = Math.round(time);
            let minutes = Math.floor(time / 60);
            let seconds = time - minutes * 60;

            seconds = seconds < 10 ? '0' + seconds : seconds;
            minutes = minutes < 10 ? '0' + minutes : minutes;

            return minutes + ':' + seconds;
        },

        //#####################################################
        //
        //
        togglePlay() {
            if (this.paused) {
                this.play();
            } else {
                this.pause();
            }
        },

        //#####################################################
        //
        //
        play () {
            this.player.playVideo()
            this.paused = false;
        },

        //#####################################################
        //
        //
        pause () {
            if (this.player) {
                this.player.pauseVideo()
            }
            this.paused = true;
            clearInterval(this.processId);
        },

        //#####################################################
        //
        //
        diffArray(arr1, arr2) {
            var newArr = [];
            arr1.forEach(function(val){
                if(arr2.indexOf(val) < 0) newArr.push(val);
            });

            arr2.forEach(function(val){
                if(arr1.indexOf(val) < 0) newArr.push(val);
            });
            return newArr;
        },

        //#####################################################
        //
        //
        deselectDialogue() {
            this.showHighlightText = false;

            var sel;
            if ( (sel = document.selection) && sel.empty ) {
                sel.empty();
            } else {
                if (window.getSelection) {
                    window.getSelection().removeAllRanges();
                }
                var activeEl = document.activeElement;
                if (activeEl) {
                    var tagName = activeEl.nodeName.toLowerCase();
                    if ( tagName == "textarea" ||
                            (tagName == "input" && activeEl.type == "text") ) {
                        // Collapse the selection to the end
                        activeEl.selectionStart = activeEl.selectionEnd;
                    }
                }
            }
        },

        //#####################################################
        //
        //
        onMouseup () {
            const selection = window.getSelection();
            if (selection.rangeCount == 0) {
                return;
            }
            const selectionRange = selection.getRangeAt(0)

            // startNode is the element that the selection starts in
            const startNode = selectionRange.startContainer.parentNode
            // endNode is the element that the selection ends in
            const endNode = selectionRange.endContainer.parentNode

            // if the selected text is not part of the highlightableEl (i.e. <p>)
            // OR
            // if startNode !== endNode (i.e. the user selected multiple paragraphs)
            // Then
            // Don't show the menu (this selection is invalid)
            console.log(startNode.isSameNode(this.highlightableEl));
            if (!startNode.isSameNode(this.highlightableEl) || !startNode.isSameNode(endNode)) {
                this.showHighlightText = false
                return
            }

            // Get the x, y, and width of the selection
            const { x, y, width } = selectionRange.getBoundingClientRect()

            // If width === 0 (i.e. no selection)
            // Then, hide the menu
            if (!width) {
                this.showHighlightText = false
                return
            }

            // Finally, if the selection is valid,
            // set the position of the menu element,
            // set selectedText to content of the selection
            // then, show the menu
            this.xHighlightMenu = x + (width / 2)
            this.yHighlightMenu = y + window.scrollY - 10
            this.selectedText = selection.toString()
            this.showHighlightText = true
            console.log("dsf");
            // TODO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            this.$apollo.query({
                // Query
                query: gql`query ($id: Int!) {
                    word(id: $id) {
                        definition {
                            word
                        }
                    }
                
                }`,
                // Static parameters
                variables: {
                    id: '1',
                },
            }).then((data) => {
                data = data.data.word[0].definition.word;
                console.log(data);
            }).catch((error) => {
                console.error(error)
            })
        }
    },
}

</script>

<style scoped>
/* .highlightMenu {
  height: 30px;
  padding: 5px 10px;
  background: #333;
  border-radius: 3px;
  position: absolute;
  top: 0;
  left: 0;
  transform: translate(-50%, -100%);
  transition: 0.2s all;
  display: flex;
  justify-content: center;
  align-items: center;
} */

.highlightMenu:after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -5px;
  transform: translateX(-50%);
  width: 0;
  height: 0;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid #1a202c;
}

/* .highlightMenuItem {
  color: #FFF;
  cursor: pointer;
}

.highlightMenuItem:hover {
  color: #1199ff;
}

.highlightMenuItem + .highlightMenuItem {
  margin-left: 10px;
} */
</style>