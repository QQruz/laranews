<form action="{{config('laranews.routes.store')}}" method="POST" id="laranews-builder">
        @csrf
        <div class="form-group" data-everything data-headlines data-sources>
            <label for="endpoint">Select endpoint:</label>
            <select name="endpoint" class="form-control">
                <option value="headlines">Top Headlines</option>
                <option value="everything">Everything</option>
                <option value="sources">Sources</option>
            </select>
        </div>

        <div class="form-group" data-everything data-headlines data-sources>
            <label for="name">Name by which request will be saved:</label>
            <input type="text" name="name" class="form-control">
        </div>
    
        <div class="form-group" data-headlines data-sources>
            <label for="category">Select category:</label>
            <select name="category" class="form-control">
                <option value="null">Select category</option>
                <option value="business">Business</option>
                <option value="entertainment">Entertainment</option>
                <option value="general">General</option>
                <option value="health">Health</option>
                <option value="science">Science</option>
                <option value="sports">Sports</option>
                <option value="technology">Technology</option>
            </select>
        </div>
        
        <div class="form-group" data-headlines data-sources>
            <label for="country">Select country:</label>
            <select name="country" class="form-control">
                <option value="null">All</option>
                <option value="ae">United Arab Emirates</option>
                <option value="ar">Argentina</option>
                <option value="at">Austria</option>
                <option value="be">Belgium</option>
                <option value="bg">Bulgaria</option>
                <option value="br">Brasil</option>
                <option value="ca">Canada</option>
                <option value="ch">Switzerland</option>
                <option value="cn">China</option>
                <option value="co">Colombia</option>
                <option value="cu">Cuba</option>
                <option value="cz">Czech</option>
                <option value="de">Germany</option>
                <option value="eg">Egypt</option>
                <option value="fr">France</option>
                <option value="gb">Great Britain</option>
                <option value="gr">Greece</option>
                <option value="hk">Hong Kong</option>
                <option value="hu">Hungary</option>
                <option value="id">Indonesia</option>
                <option value="ie">Ireland</option>
                <option value="il">Israel</option>
                <option value="in">India</option>
                <option value="it">Italy</option>
                <option value="jp">Japan</option>
                <option value="kr">South Korea</option>
                <option value="lt">Lithuania</option>
                <option value="lv">Latvia</option>
                <option value="ma">Morocco</option>
                <option value="mx">Mexico</option>
                <option value="my">Malaysia</option>
                <option value="ng">Nigeria</option>
                <option value="nl">Netherlands</option>
                <option value="no">Norway</option>
                <option value="nz">New Zeland</option>
                <option value="ph">Philippines</option>
                <option value="pl">Poland</option>
                <option value="pt">Portugal</option>
                <option value="ro">Romania</option>
                <option value="rs">Serbia</option>
                <option value="ru">Russia</option>
                <option value="sa">Saudi Arabia</option>
                <option value="se">Sweden</option>
                <option value="sg">Singapore</option>
                <option value="si">Slovenia</option>
                <option value="th">Thailand</option>
                <option value="tr">Turkey</option>
                <option value="tw">Taiwan</option>
                <option value="ua">Ukraine</option>
                <option value="us">United States</option>
                <option value="ve">Venezuela</option>
                <option value="za">South Africa</option>
            </select>
        </div>
    
        <div class="form-group" data-headlines data-everything>
            <label for="q">Enter search term:</label>
            <input type="text" name="q"  class="form-control">
        </div>
        
        <div class="form-group" data-everything>
            <label for="qInTitle">Enter search term to be included in title:</label>
            <input type="text" name="qInTitle" class="form-control">
        </div>

        <div class="form-group" data-headlines data-everything>
            <label for="pageSize">How many results to fetch in one call (1-100): </label>
            <input type="number" name="pageSize" min="1" max="100" class="form-control">
        </div>
    
        <div class="form-group" data-headlines data-everything>
            <label for="page">From which page to start: </label>
            <input type="number" name="page" class="form-control">
        </div>

        <div class="form-group" data-everything>
            <label for="domains">Search domains (comma separated): </label>
            <input type="text" name="domains" class="form-control">
        </div>

        <div class="form-group" data-everything>
            <label for="excludeDomains">Exclude domains (comma separated): </label>
            <input type="text" name="excludeDomains" class="form-control">
        </div>

        <div class="form-group" data-everything>
            <label for="from">From which date: </label>
            <input type="date" name="from" class="form-control">
        </div>

        <div class="form-group" data-everything>
            <label for="to">To which date: </label>
            <input type="date" name="to" class="form-control">
        </div>

        <div class="form-group" data-everything data-sources>
            <label for="language">Choose language: </label>
            <select name="language" class="form-control">
                <option value="ar">Argentinian</option>
                <option value="de">German</option>
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="he">Hebrew</option>
                <option value="it">Italian</option>
                <option value="nl">Dutch</option>
                <option value="de">Germany</option>
                <option value="no">Norwegian</option>
                <option value="pt">Portuguese</option>
                <option value="ru">Russian</option>
                <option value="se">Swedish</option>
                <option value="ud">Urdu</option>
                <option value="zh">Chinese</option>
            </select>
        </div>

        <div class="form-group" data-everything>
            <label for="sortBy">Sort results by: </label>
            <select name="sortBy" class="form-control">
                    <option value="relevancy">relevancy</option>
                    <option value="popularity">popularity</option>
                    <option value="publishedAt">date of publishing</option>
            </select>
        </div>
    
        <button type="submit" class="btn btn-primary">Send</button>
    
    </form>
    <script>
        
        (function (){
            const $endpoint = document.querySelector('select[name="endpoint"]')
            const $form = document.querySelector('#laranews-builder')

            function toggle() {
                const endpointValue = $endpoint.value
                const $divs = $form.querySelectorAll('div')
                
                $divs.forEach(div => {
                    if(div.hasAttribute("data-" + endpointValue)) {
                        div.classList.add('d-block')
                        div.classList.remove('d-none')
                        div.querySelector('.form-control').setAttribute("enabled", true)
                        div.querySelector('.form-control').removeAttribute("disabled")
                    } else {
                        div.classList.add('d-none')
                        div.classList.remove('d-block')
                        div.querySelector('.form-control').setAttribute("disabled", true)
                        div.querySelector('.form-control').removeAttribute("enabled")
                    }
                })
            }

            toggle()
            $endpoint.addEventListener('change', toggle)
            
        })();
        
    </script>