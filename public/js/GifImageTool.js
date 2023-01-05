class GifImageTool {
    static get toolbox() {
        return {
            title: 'Gif Image',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({data,api,config}){
        this.api = api;
        this.config = config || {};

        this.data = data || {};
        this.wrapper = undefined;
        endpoint = this.config.endpoint
        search_input.onkeyup = function (event) {
            let keyword = event.target.value;
            if (keyword.length > 3) {
                _getImages(keyword)
            }
        }
    }

    render(){
        this.wrapper = document.createElement('div');
        this.wrapper.classList.add('gif-image-container');
        modal.style.display = "block";

        if(chosen_url !== ""){
            this._createImage(chosen_url);
            return this.wrapper;
        }

        const insertBtn = document.getElementById('insertBtn');

        insertBtn.addEventListener('click', (event) => {
            if(chosen_url !== "") {
                this._createImage(chosen_url);
                modal.style.display = "none";
                this.save();
                return this.wrapper;
            }
        });

        return this.wrapper;
    }
    _createImage(selected_url){
        const image = document.createElement('img');
        image.src = selected_url;
        this.wrapper.innerHTML = '';
        this.wrapper.appendChild(image);
        chosen_url = "";
    }
    save(blockContent){
        if(blockContent !== undefined) {
            const image = blockContent.querySelector('img');
            return {
                url: image.src,
            }
        }
        return {};
    }


}
let endpoint;
let offset = 0;
let limit = 12;
let chosen_url = "";
let modal = document.getElementById("gif_modal");
let search_input = document.getElementById("input-search-gif");
let close_btn = document.getElementsByClassName("close")[0];

close_btn.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}


function _getImages(keyword){
    let final_endpoint = `${endpoint}?q=${keyword}&limit=${limit}&offset=${offset}`
    $.ajax({
        url: final_endpoint,
        success:function (result) {
            let images = result.data;
            let pagination = result.pagination;
            $('#load_more_btn').remove();
            images.map( (single) => {
                $("#gif-images-container").append(`
                    <div class="col-md-3 mt-2" >
                        <div class="single-thumbnail" style="background-image: url('${single.images.preview_gif.url}')" data-original-url="${single.images.original.url}"></div>
                    </div>
                `)
            })

            if(pagination.total_count >= pagination.offset){
                offset += limit;
                $("#modal_body").append(`
                    <button type="button" class="btn btn-dark px-5" id="load_more_btn" onclick="_getImages('${keyword}')">load more</button>
                `)
            }

            $(".single-thumbnail").on('click',function () {
                let $this = $(this);
                if(!$this.hasClass('selected')) {
                    $('.single-thumbnail.selected').removeClass('selected');
                    $this.addClass('selected');
                    chosen_url = $this.data('original-url')
                }
            })
        }
    })
}

