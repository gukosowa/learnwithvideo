<template>
    <div class="text-white flex flex-grow flex-row w-full body" style="">
        <!-- container -->
        <div :class="{ 'w-3/5 flex justify-center' : editMode, 'container flex flex-col items-center' : !editMode }" style="padding: 0.3rem;"> 
            <div class="home w-full flex flex-col" style="max-width:900px;" :class="{ 'home-edit' : editMode }">

                <!-- Video container -->
                <div ref="container" class="video-container bg-black shadow-lg border rounded-lg overflow-hidden border-gray-900 flex flex-col z-10 relative" style="">
                    <div style="position:relative; margin-top:56.25%; width:100%; display:block;"></div>
                    <div style="
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        z-index: 18;
                        box-shadow: inset 0px 0px 29px -3px #000000;
                        pointer-events: none;
                    "></div>
                    <youtube class="youtube-container self-center w-full h-full z-0" 
                        style="position:absolute; width:100%; height:100%;"
                        ref="youtube"
                        player-width="100%"
                        player-height="100%"
                        :player-vars="{ resize: true, autoplay: 1, controls: 0, showinfo: 0, cc_load_policy: 0, cc_lang_pref:'en', wmode:'transparent' }" 
                        :video-id="url"
                        @ready="ready" 
                        @paused="pause" 
                        @playing="playing"
                    ></youtube>
                    <div class="w-full absolute top-0 inset-x-0 z-20">
                        <button @click="editMode = !editMode; deselectDialogue(); ((!editMode) ? play() : pause())" class="z-10 bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none z-20"
                        :class="{ 'border-none bg-gray-900 hover:bg-gray-800' : !editMode }">
                            {{ (editMode ? "Normal Mode" : "Edit Mode") }}
                        </button>
                    </div>
                    <div class="bg-black z-20">
                        <div class="bg-gray-700 w-full h-1" v-bind:style="{ width: progress + '%' }"></div>
                    </div>
                </div>

                <!-- Text selection overlay TODO  @mouseover="pause" @mouseleave="play" --> 
                <div v-show="showHighlightText" class="flex flex-row highlightMenu rounded-lg bg-gray-900 py-3 px-2 z-50 absolute" style="transform: translate(-50%, -100%);" :style="{ left: `${xHighlightMenu}px`, top: `${yHighlightMenu}px` }" @mousedown.prevent="">
                    <span class="w-32 text-center cursor-pointer" @mousedown.prevent="getDefinition">
                        Add new Word
                    </span>
                    <span class="w-24 text-center cursor-pointer"  @mousedown.prevent="openNewWindow('https://jisho.org/search/' + selectedText + '%20%23words')">
                        Search
                    </span>
                    <!-- <span class="ml-2" @mousedown.prevent="handleAction('highlight')">
                        Highlight
                    </span> -->
                    <!-- You can add more buttons here -->
                </div>

                <!-- CONTENT  TODO  @mouseover="pause" @mouseleave="play"  -->
                <div @mousedown="deselectDialogue" @mouseup="onMouseup" class="-mt-3 mx-3 p-6 py-12 bg-gray-800 pb-0 shadow-lg border rounded-lg border-gray-900 flex flex-col mt-10 z-0 relative" style="background-color: #283243;">
                    <div id="selectedHighlight" class="absolute" style="background-color: rgb(32, 97, 208);"></div>
                    <div ref="dialogueField" :style="{ cursor: (!editMode ? 'help' : '') }" @mousedown="clearHighlightBox" class="text-4xl text-center z-10">
                        {{ editText }}
                    </div>

                    <div ref="translationField" class="text-sm text-center z-10 relative bottom-0 mt-4 mb-2 self-center" style="opacity:0.5;">
                        {{ translationText }}
                    </div>
                </div>

                <!-- Controlls -->
                <div class="flex flex-col shadow-lg bottom-0 mt-4 mb-5 p-4 rounded-lg z-20" style="background-color: #0f1218;">

                    <!-- Edit controlls -->
                    <div @mousedown="timeLineClick" class="flex flex-col" v-show="editMode">
                        <div class="flex items-center w-full mb-1">
                            <div class="w-full flex flex-row">

                                <!-- Insert button -->
                                <button @click="addEmptyDialogue" class="bg-gray-700 w-6 mr-3 hover:bg-gray-600 text-white font-bold py-2 px-2 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                                    *
                                </button>

                                <!-- Insert button -->
                                <button @click="saveDialogue" 
                                class="bg-gray-700 mr-3 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none"
                                :class="{ 'bg-red-500 hover:bg-red-600 border-red-800' : editTextDirty }" style="transition: 0.2s; min-width: 7rem;">
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
                        <div class="mx-5 relative w-full">
                            <vue-slider 
                                v-model="currentTime"
                                tooltip="focus" tooltipPlacement="top"
                                width="100%"
                                height="0.9rem"
                                :lazy="true"
                                :duration="0"
                                :min="0"
                                :interval="0.1"
                                :max="durationTime"
                                :tooltip-formatter="timeFormater"
                                @change="changeCurrentTime"
                            ></vue-slider>
                            <div style="position:absolute; width:5px; height:2px; bottom:0px; background-color:rgb(181, 182, 103);"
                                :style="{ left: (getProgressFromTime(item) * 100) + '%' }"
                                 v-for="(item, index) in timeline" :key="index"></div>
                        </div>

                        <!-- time as text -->
                        <span class="text-sm text-center" style="min-width: 5.5rem">{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>
                    </div>

                </div>
            </div>
        </div>
        <!-- v-on:mousedown.prevent -->
        <div class="w-0" :style="editMode ? 'visibility:visible;' : 'visibility:hidden;'" :class="{ 'w-2/5 ml-10 block' : editMode }">
            <div class="bg-gray-900 pb-4 shadow-lg slide-out-editmode" :class="{ 'slide-in-editmode' : editMode }" style="border-bottom-left-radius: 8px;">
                <div class="bg-gray-900 flex flex-row">
                    <div class="w-1/2 text-center py-2">
                        Database
                    </div>
                    <div class="text-center py-2" style="opacity:0.4;">
                        &#x2BC7;
                    </div>
                    <div class="w-1/2 text-center py-2">
                        Jisho.org
                    </div>
                </div>
                <div class="bg-gray-800 flex flex-row">
                    <ul id="listDB" class="w-1/2 definition-list h-64 overflow-y-auto relative">
                        <div v-show="loadingDB" class="absolute top-0 right-0 looping-rhombuses-spinner m-5" style="postition:absolute !important;">
                            <div class="rhombus"></div>
                            <div class="rhombus"></div>
                            <div class="rhombus"></div>
                        </div>
                        <li @click="getDefinitionDetail(item.id, index)" :id="item.id" class="p-2 text-2xl cursor-pointer" :style="(listIndexDB == index) ? 'background-color: rgb(48, 124, 71) !important;' : ''" v-for="(item, index) in definitions"  :key="item.id">
                            {{ (!item.word ? item.furigana : item.word) }}
                        </li>
                    </ul>
                    <ul class="w-1/2 definition-list h-64 overflow-y-auto relative">
                    <!-- loadingJisho -->
                        <div v-show="loadingJisho" class="absolute top-0 right-0 looping-rhombuses-spinner m-5" style="postition:absolute !important;">
                            <div class="rhombus"></div>
                            <div class="rhombus"></div>
                            <div class="rhombus"></div>
                        </div>
                        <li @click="getDetailFromJisho(index)" :id="index" class="p-2 text-2xl cursor-pointer" :style="(listIndexJisho == index) ? 'background-color: rgb(48, 88, 124) !important;' : ''" v-for="(item, index) in jishoDefinitions"  :key="index">
                            {{ (!item.japanese[0].word ? item.japanese[0].reading : item.japanese[0].word) }}
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col p-4" v-show="listIndexJisho != -1 || listIndexDB != -1">
                    <!-- <div class="w-1/3 h-full bg-gray-900" :style="'background: url(https://picsum.photos/200/200) no-repeat center; background-size: cover;'"> -->
                        <!-- <img src="https://picsum.photos/566/500" /> -->
                        <!-- <img :src="detailDefinition.image" /> -->
                    <!-- </div> -->
                    <div class="absolute right-0 mr-4 flex flex-col text-right">
                        <span v-if="detailDefinition.jlpt != -1" class="text-sm"><span class="text-white">JLPT:</span> <Click-to-Edit v-model="detailDefinition.jlpt" type="number" class="text-orange-500" inputStyle="width:40px;"/></span>
                        <span class="text-sm" v-show="listIndexDB != -1"><span class="text-orange-500"> <pre>{{ (detailDefinition.part_of_speech != undefined ? convertPartOfSpeech(detailDefinition.part_of_speech) : "") }}</pre></span></span>
                        <span class="text-sm" v-show="listIndexJisho != -1"><span class="text-orange-500"> <pre>{{ (detailDefinition.part_of_speech != undefined ? detailDefinition.part_of_speech.replace(", ", "\n") : "") }}</pre></span></span>
                        <span class="text-sm" v-show="detailDefinition.id != -1"><span class="text-white">#</span> <span class="text-orange-500"> {{ detailDefinition.id }}</span></span>
                    </div>
                    <span class="text-md" v-if="detailDefinition.word != undefined"><Click-to-Edit v-model="detailDefinition.furigana" inputStyle="width:70%;" type="text" class="text-white" /></span>
                    <!-- <a :href="'https://jisho.org/word/' + detailDefinition.word" target="_blank" @click="pause"></a> -->
                    <span class="text-4xl" v-if="detailDefinition.word != undefined"><Click-to-Edit v-model="detailDefinition.word" type="text" inputStyle="width:70%;" class="text-white" /></span> 
                    <span class="text-sm mt-2"><span class="text-orange-500">Definition:</span><br><Click-to-Edit :value="convertDefinition(detailDefinition.definition)" :input="detailDefinition.definition" type="text" inputStyle="width:70%;" class="text-white" /></span>
                    <span class="text-sm mt-2"><span class="text-orange-500">Tags:</span><br><Click-to-Edit v-model="detailDefinition.tags" type="text" inputStyle="width:70%;" class="text-white" /></span>
                </div>
    
                <div class="flex flex-row justify-around">
                    <button v-show="listIndexDB != -1" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                        ✔️ Apply to selection
                    </button>
    
                    <button v-show="listIndexJisho != -1" @click="pullFromJisho" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                        &#x2BC7; Pull Word
                    </button>
    
                    <button v-show="listIndexJisho != -1 || listIndexDB != -1"  @click="openNewWindow('https://jisho.org/search/' + detailDefinition.word + '%20%23words')" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 border-b-4 border-gray-800 hover:border-gray-700 rounded focus:outline-none">
                        🔍 Search
                    </button>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import gql from 'graphql-tag';
import ClickToEdit from '@/components/ClickToEdit.vue';
import { setTimeout } from 'timers';

export default {
    name: 'home',
    components: {
        ClickToEdit
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    data () {
        return {
            editText: "",
            translationText: "",
            currentTime: 0,
            progress: 0,
            processId: null,
            duration: 100,
            url: "V6ZfH28jU28",
            aspectRatio: 0.5625,
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
            translation: [
            "The ivy entwines itself around the run-down row house, while my writing brush earnestly runs (across the page).", 
            "The evening primrose whispered. I will run through the town of Edo.", 
            "On a moonlit night, on the path of my fleeting life, I shall become geniune artist!",
            "If my dream comes true, I'll be a disembodied soul,",
            "and go to the summer fields as a pastime",
            "It sings and echoes in the world, the sound of the three-stringed guitar.",
            "The cool breeze from the north shakes the head of the plants.",
            "The projected shadow of the moon draws an arc.",
            "Now, the leading man is me, in fine Edo clothing!"],
            cachedTimeline: [],
            cacheCurrentDialogueId: -1,
            dialogueId: 0,
            timeFormater: v => `${this.formatTime(v)}`,
            // eslint-disable-next-line
            hightlightCurrentDialogue: b => [
                [this.getProgressFromTime(this.timeline[this.dialogueId])*100, (!this.timeline[this.dialogueId+1]) ? 100 : this.getProgressFromTime(this.timeline[this.dialogueId+1])*100, { backgroundColor: 'red' }]
            ],
            editTextDirty: false,

            editMode: true,

            oembed: {},
            
            xHighlightMenu: 0,
            yHighlightMenu: 0,
            showHighlightText: false,
            selectedText: "",
            wordTable: [{vocab_id:1, start_pos:0, dialogue_id:0, word:"鳥", custom_info:"fgf"}],
            definitions: {},
            jishoDefinitions: {},
            detailDefinition: {},
            loadingDB: false,
            loadingJisho: false,
            listIndexDB: -1,
            listIndexJisho: -1,
        }
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
        // var vm = this;
        

        // // GET request for remote image
        // this.$apollo.query({
        //     // Query
        //     query: gql`query ($url: String!) {
        //         youtubeoembed(url: $url) {
        //             width
        //             height
        //         }
            
        //     }`,
        //     // Static parameters
        //     variables: {
        //         url: vm.url,
        //     },
        // }).then((response) => {
        //     vm.oembed = response.data.youtubeoembed;
        // }).catch((error) => {
        //     console.error(error)
        // });

        window.addEventListener("resize", function() {
            // vm.setContainerAspectRatio();
        });
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    beforeDestroy () {
        // window.removeEventListener('mouseup', this.onMouseup)
    },

    //* /////////////////////////////////////////////////////////////////
    //* /////////////////////////////////////////////////////////////////
    methods: {
        //#####################################################
        //
        //
        setContainerAspectRatio() {
            var element = document.querySelector(".youtube-container");
            var height = element.offsetWidth * this.aspectRatio;
            element.style.setProperty("height", height + "px")
        },

        //#####################################################
        //
        //
        async getDefinitions() {
            this.loadingDB = true;
            this.loadingJisho = true;
            var vm = this;
            // console.log("Get DB Definitions List and select: " + selectWord, vm.selectedText);

            this.getDefinitionFromJisho();

            // GET request for remote image
            await this.$apollo.query({
                // Query
                query: gql`query Definitions($word: String!) {
                    definition(word: $word, furigana: $word) {
                        id
                        word
                        furigana
                    }
                
                }`,
                // Static parameters
                variables: {
                    word: encodeURIComponent(vm.selectedText),
                },

                fetchPolicy: 'no-cache'
            }).then((data) => {
                this.loadingDB = false;
                
                // data = data.data.word[0].definition.word;
                console.log("Get DB Definition list", data);
                var definition = data.data.definition;

                this.definitions = definition.sort(function(a, b){
                    return a.word.length - b.word.length;
                });


                // if (selectWord != "") {
                    // let i = 0;
                    // this.definitions.forEach(function(def) {
                    //         if (def.word == selectWord || def.furigana == selectWord) {
                    //             vm.listIndexJisho = -1;
                    //             vm.listIndexDB = i;
                    //         }
                    //     i++;
                    // });
                // } else {
                    let found = false;
                    if (vm.definitions.length > 0) {
                        for (let i = 0; i < vm.definitions.length; i++) {
                            let def = vm.definitions[i];
                            if (def.word == vm.selectedText || def.furigana == vm.selectedText) {
                                vm.getDefinitionDetail(def.id, i);
                                found = true;
                                break;
                            }
                        }
                    }
                    if (found == false) {
                        console.log("Nothing found in own list > select from jisho");
                        vm.getDefinitionFromJisho(true);
                    }
                // }
                
                // definition.forEach(function (word) {

                // });
            }).catch((error) => {
                console.error(error)
            })

        },

        //#####################################################
        //
        //
        async getDefinitionDetail(dbid, index = -1) {
            this.listIndexJisho = -1;
            this.listIndexDB = index;
            if (dbid == undefined) {
                return;
            }
            console.log(dbid);
            // GET request for remote image
            await this.$apollo.query({
                // Query
                query: gql`query Definition($id: Int!) {
                    definition(id: $id) {
                        id
                        word
                        furigana
                        part_of_speech
                        image
                        jlpt
                        tags
                        definition
                    }
                
                }`,
                // Static parameters
                variables: {
                    id: dbid,
                },
                
                fetchPolicy: 'no-cache'
            }).then((data) => {
                // data = data.data.word[0].definition.word;
                // console.log(data.data.definition);
                console.log(data);
                this.detailDefinition = data.data.definition[0];

                // definition.forEach(function (word) {

                // });
            }).catch((error) => {
                console.error(error)
            })
        },

        //#####################################################
        //
        //
        async getDefinitionFromJisho(select) {
            // var proxyUrl = 'https://cors-anywhere.herokuapp.com/',
            //     targetUrl = 'https://jisho.org/api/v1/search/words?keyword=' + this.selectedText
            // fetch(proxyUrl + targetUrl)
            // .then(blob => blob.json())
            // .then(data => {
            //     this.jishoDefinitions = data.data
            //     console.table(data.data);
            // })
            // .catch(e => {
            //     console.log(e);
            //     return e;
            // });

            var vm = this;
            // GET request for remote image
            await this.$apollo.query({
                // Query
                query: gql`query ($keyword: String!) {
                    jisho(keyword: $keyword) {
                        data {
                            japanese {
                                reading,
                                word
                            }
                            senses {
                                english_definitions
                                parts_of_speech
                                tags
                            }
                            jlpt,
                            is_common,
                            slug
                        },
                        meta
                    }
                }`,
                // Static parameters
                variables: {
                    keyword: vm.selectedText,
                },
                
                fetchPolicy: 'no-cache'
            }).then((result) => {

                console.log("Get Definition from JISHO with select " + select, result.data.jisho);

                this.loadingJisho = false;

                if (result.data.jisho.meta != 200) {
                    this.jishoDefinitions = {};
                    return;
                }

                this.jishoDefinitions = result.data.jisho.data;

                this.jishoDefinitions = this.jishoDefinitions.sort(function(a, b){
                    if (a.japanese[0].word != undefined && b.japanese[0].word != undefined) {
                        return a.japanese[0].word.length - b.japanese[0].word.length;
                    } else {
                        return 1;
                    }
                });

                if (select == true) {
                    this.getDetailFromJisho(0)
                }
                // this.jishoDefinitions = data;

                // if (this.definitions.length > 0) {
                //     this.getDefinitionDetail(this.definitions[0].id);
                // }
                // definition.forEach(function (word) {

                // });
            }).catch((error) => {
                console.error(error)
            })

            
        },

        //#####################################################
        //
        //
        async getDetailFromJisho(index) {
            this.listIndexDB = -1;
            if (this.jishoDefinitions.length == 0) {
                this.listIndexJisho = -1;
                return;
            }

            this.listIndexJisho = index;

            var def = this.jishoDefinitions[index];
            if (def.jlpt.length > 0 && def.jlpt[0] != undefined) {
                this.detailDefinition.jlpt = def.jlpt[0];
            }
            this.detailDefinition.part_of_speech = def.senses[0].parts_of_speech.join(", ");
            this.detailDefinition.id = -1;
            this.detailDefinition.furigana = def.japanese[0].reading;
            this.detailDefinition.word = def.japanese[0].word;
            this.detailDefinition.definition = def.senses[0].english_definitions.join(", ");
            this.detailDefinition.tags = def.senses[0].tags.join(", ");
        },

        //#####################################################
        //
        //
        async pullFromJisho() {
            this.detailDefinition.word = !this.detailDefinition.word ? "" : this.detailDefinition.word;
            this.detailDefinition.furigana = !this.detailDefinition.furigana ? "" : this.detailDefinition.furigana;
            this.detailDefinition.part_of_speech = !this.detailDefinition.part_of_speech ? "" : this.detailDefinition.part_of_speech;
            this.detailDefinition.definition = !this.detailDefinition.definition ? "" : this.detailDefinition.definition;
            this.detailDefinition.image = !this.detailDefinition.image ? "" : this.detailDefinition.image;
            this.detailDefinition.ispeech_id = !this.detailDefinition.ispeech_id ? -1 : parseInt(this.detailDefinition.ispeech_id);
            this.detailDefinition.jlpt = !this.detailDefinition.jlpt ? -1 : parseInt(this.detailDefinition.jlpt);
            this.detailDefinition.tags = !this.detailDefinition.tags ? "" : this.detailDefinition.tags;
            console.log(encodeURIComponent(this.detailDefinition.word));
            var vm = this;
            console.log(this.detailDefinition);
            this.$apollo.mutate({
                // Query
                mutation: gql`mutation ($word: String, $furigana: String, $part_of_speech: String, $definition: String, $image: String, $ispeech_id: Int, $jlpt: Int, $tags: String) {
                    createDefinition(word : $word, furigana : $furigana, part_of_speech : $part_of_speech, definition : $definition, image : $image, ispeech_id : $ispeech_id, jlpt : $jlpt, tags : $tags) {
                        id
                        word
                        furigana
                        definition
                    }
                }`,
                // Parameters
                variables: {
                    word: encodeURIComponent(vm.detailDefinition.word),
                    furigana: encodeURIComponent(vm.detailDefinition.furigana),
                    part_of_speech: encodeURIComponent(vm.detailDefinition.part_of_speech),
                    definition: encodeURIComponent(vm.detailDefinition.definition),
                    image: encodeURIComponent(vm.detailDefinition.image),
                    ispeech_id: encodeURIComponent(vm.detailDefinition.ispeech_id),
                    jlpt: encodeURIComponent(vm.detailDefinition.jlpt),
                    tags: encodeURIComponent(vm.detailDefinition.tags)
                },
                
            }).then((response) => {
                // Result
                console.log("MADE DEFINITION");
                console.log(response.data.createDefinition.id)

                this.definitions.push({
                    word: this.detailDefinition.word,
                    furigana: this.detailDefinition.furigana,
                    part_of_speech: this.detailDefinition.part_of_speech,
                    definition: this.detailDefinition.definition,
                    image: this.detailDefinition.image,
                    ispeech_id: this.detailDefinition.ispeech_id,
                    jlpt: this.detailDefinition.jlpt,
                    tags: this.detailDefinition.tags
                });

                setTimeout(function() {
                    var listDB = document.getElementById("listDB");
                    listDB.scrollTop = 9999999999999999;
                }, 50); 

                let i = 0;
                vm.definitions.forEach(function(def) {
                        if (def.word == vm.detailDefinition.word || def.furigana == vm.detailDefinition.furigana) {
                            vm.listIndexJisho = -1;
                            vm.listIndexDB = i;
                        }
                    i++;
                });

                vm.getDefinitionDetail(response.data.createDefinition.id, vm.listIndexDB);
                console.log(response)
            }).catch((res) => {
                console.log(res);
                console.log(res.graphQLErrors);
                const errors = res.graphQLErrors.map((error) => {
                    return error.message;
                });

                console.error(errors);
            });
        },

        //#####################################################
        //
        //
        convertPartOfSpeech(short) {
            var pof = "";
            switch(short) {
                case "n":
                    pof = "Noun"
                    break;
                case "v":
                    pof = "Verb"
                    break;
                case "a":
                    pof = "Adjective"
                    break;
                case "i":
                    pof = "i Adjective"
                    break;
                case "in":
                    pof = "Interjection"
                    break;
                case "na":
                    pof = "na Adjective"
                    break;
                case "c":
                    pof = "Conjuction"
                    break;
                case "adv":
                    pof = "Adverb"
                    break;
                case "pA":
                    pof = "prenoun Adjective"
                    break;
                case "p":
                    pof = "Particle"
                    break;
                case "su":
                    pof = "Suffix"
                    break;
                case "pr":
                    pof = "Prefix"
                    break;
                case "pp":
                    pof = "Preposition"
                    break;
                case "mw":
                    pof = "Measure word"
                    break;
            }
            return pof;
        },

        //#####################################################
        //
        //
        convertDefinition(short) {
            if (short != undefined) {
                return short.replace(/;/g, ", ");
            } else {
                return "";
            }
        },

        //#####################################################
        //
        //
        openNewWindow(url) {
            this.pause();
            this.popupCenter(url, "Jisho", 1000, 700);
        },

        popupCenter(url, title, w, h) {
            var left = window.screenX + (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2) - 350;
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
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
            this.cacheCurrentDialogueId = -1;
            this.deselectDialogue();
        },

        //#####################################################
        //
        //
        timeLineRelease() {
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
            this.player = event.target
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
            }, 1000/60);
        },

        //#####################################################
        //
        //
        updateShowDialogue() {
            this.currentTime = this.player.getCurrentTime();
            this.dialogueId = 0;
            for(var i = 0;i < this.timeline.length; i++) {
                if (this.currentTime > this.timeline[i]) {
                    this.dialogueId = i;
                }
            }
            if (this.cacheCurrentDialogueId != this.dialogueId) {
                this.deselectDialogue();
                this.editTextDirty = false;
                this.editText = this.dialogue[this.dialogueId];
                this.translationText = this.translation[this.dialogueId];
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
        getProgressFromTime(time) {
            if (!this.duration) {
                return 0;
            }
            return time / this.duration;
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
            this.clearHighlightBox();
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
        clearSelection() {
            if (window.getSelection) {window.getSelection().removeAllRanges();}
            else if (document.selection) {document.selection.empty();}
        },

        //#####################################################
        //
        //
        clearHighlightBox() {
            var highlightBox = document.getElementById("selectedHighlight");
            highlightBox.style.width = 0;
            highlightBox.style.height = 0;
        },

        //#####################################################
        //
        //
        onMouseup () {
            const selection = window.getSelection();
            if (selection.rangeCount == 0 || this.editMode == false) {
                return;
            }
            const selectionRange = selection.getRangeAt(0)

            // startNode is the element that the selection starts in
            // const startNode = selectionRange.startContainer.parentNode
            // endNode is the element that the selection ends in
            // const endNode = selectionRange.endContainer.parentNode

            // if the selected text is not part of the highlightableEl (i.e. <p>)
            // OR
            // if startNode !== endNode (i.e. the user selected multiple paragraphs)
            // Then
            // Don't show the menu (this selection is invalid)
            // console.log(startNode.isSameNode(this.highlightableEl));
            // if (!startNode.isSameNode(this.highlightableEl) || !startNode.isSameNode(endNode)) {
            //     this.showHighlightText = false
            //     return
            // }

            // Get the x, y, and width of the selection
            const { x, y, width, height } = selectionRange.getBoundingClientRect()

            // If width === 0 (i.e. no selection)
            // Then, hide the menu
            if (!width) {
                this.showHighlightText = false
                return
            }

            var highlightBox = document.getElementById("selectedHighlight");
            var highlightBoxParent = highlightBox.parentElement;

            highlightBox.style.left = (x - highlightBoxParent.offsetLeft - 1) + "px";
            highlightBox.style.top = ((y - highlightBoxParent.offsetTop + 9) + window.scrollY - 10) + "px";
            highlightBox.style.width = width;
            highlightBox.style.height = height;
            

            // Finally, if the selection is valid,
            // set the position of the menu element,
            // set selectedText to content of the selection
            // then, show the menu
            this.xHighlightMenu = x + (width / 2)
            this.yHighlightMenu = y + window.scrollY - 10
            this.selectedText = selection.toString()

            if (this.showHighlightText == false) {
                this.getDefinitions();
                this.pause();
            }

            this.showHighlightText = true

            //this.clearSelection();
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


.definition-list li:nth-child(even) { 

}
.definition-list li:nth-child(odd) {
    background-color: rgba(0, 0, 0, 0.1);
}
.definition-list li:hover {
    background-color: rgba(0, 0, 0, 0.4);
}

.body {
    background-color: rgb(18, 29, 47);
    /* background-image: linear-gradient(-31deg, rgb(29, 33, 37) 0%, rgb(32, 41, 56) 100%); */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1609' height='1340.8' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.02'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/svg%3E");
}

.home {
    transition: margin 0.2s;
    margin-top:5%;
}
.home-edit {
    margin-top:2%;
    margin-left:8%; 
}

@media (min-width: 1920px) { 
    .home {
        margin-top: 12%; 
    }
}

.slide-out-editmode {
    opacity: 0;
    transition-duration: 0.3s;
    /* -webkit-transform: translateX(100%); */
    position: relative;
    margin-left: 100px;
    min-width: 274px;
}

.slide-in-editmode {
    opacity: 1;
    /* -webkit-transform: translateX(0%); */
    margin-left: 0px;
    min-width: 274px;
}

.looping-rhombuses-spinner, .looping-rhombuses-spinner * {
    box-sizing: border-box;
}

.looping-rhombuses-spinner {
    width: calc(15px * 4);
    height: 15px;
}

.looping-rhombuses-spinner .rhombus {
    height: 15px;
    width: 15px;
    background-color: #c7dbf5;
    left: calc(15px * 4);
    position: absolute;
    margin: 0 auto;
    border-radius: 2px;
    transform: translateY(0) rotate(45deg) scale(0);
    animation: looping-rhombuses-spinner-animation 2500ms linear infinite;
}

.looping-rhombuses-spinner .rhombus:nth-child(1) {
    animation-delay: calc(2500ms * 1 / -1.5);
}

.looping-rhombuses-spinner .rhombus:nth-child(2) {
    animation-delay: calc(2500ms * 2 / -1.5);
}

.looping-rhombuses-spinner .rhombus:nth-child(3) {
    animation-delay: calc(2500ms * 3 / -1.5);
}

@keyframes looping-rhombuses-spinner-animation {
    0% {
    transform: translateX(0) rotate(45deg) scale(0);
    }
    50% {
    transform: translateX(-233%) rotate(45deg) scale(1);
    }
    100% {
    transform: translateX(-466%) rotate(45deg) scale(0);
    }
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