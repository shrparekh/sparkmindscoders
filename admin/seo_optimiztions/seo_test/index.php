<?php include("layout/header.php"); ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 d-flex align-items-center">
                    <!-- <h2>Seo Technical</h2> -->
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="index-2.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Seo Optimisation</a></li>
                        <li class="breadcrumb-item active">SEO Meta Checker with Keyword Search</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metaTitle">Meta Title:</label>
                                    <input type="text" id="metaTitle" name="metaTitle" placeholder="Enter your meta title..." class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">

                                    <label for="metaKeyword">Meta Keywords:</label>
                                    <input type="text" id="metaKeyword" name="metaKeyword" placeholder="Enter your meta keywords (comma-separated)..." class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                             <div class="col-md-12">
                                <div class="form-group">

                                    <label for="metaKeyword">Search Keyword:</label>
                                    <input type="text" id="searchKeyword" name="searchKeyword" placeholder="Enter keyword to search..." class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <label for="metaDescription">Meta Description:</label>
                                <textarea id="metaDescription" name="metaDescription" rows="4" placeholder="Enter your meta description..." class="form-control"></textarea>

                            </div>
                        </div>
                        
                        
                        
                        <div class="row clearfix">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button onclick="checkMeta()" class="btn my-4 p-3">Check Meta Data</button>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="body">
                                <div class="container">
                                <div class="row clearfix ">
                                   <div class="col-md-7">
                                   <div id="metaResults" class="status"></div>
                                   <div id="keywordResults" class="keyword-result"></div>
                                   </div>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- <label for="metaTitle">Meta Title:</label>
                    <input type="text" id="metaTitle" name="metaTitle" placeholder="Enter your meta title...">

                    <label for="metaDescription">Meta Description:</label>
                    <textarea id="metaDescription" name="metaDescription" rows="4" placeholder="Enter your meta description..."></textarea>

                    <label for="metaKeyword">Meta Keywords:</label>
                    <input type="text" id="metaKeyword" name="metaKeyword" placeholder="Enter your meta keywords (comma-separated)...">

                    <label for="searchKeyword">Search Keyword:</label>
                    <input type="text" id="searchKeyword" name="searchKeyword" placeholder="Enter keyword to search...">

                    <button onclick="checkMeta()">Check Meta Data</button>

                    <div id="metaResults" class="status"></div>

                    <div id="keywordResults" class="keyword-result"></div> -->
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    function checkMeta() {
        const metaTitle = document.getElementById('metaTitle').value.trim();
        const metaDescription = document.getElementById('metaDescription').value.trim();
        const metaKeywords = document.getElementById('metaKeyword').value.trim();
        const searchKeyword = document.getElementById('searchKeyword').value.trim();

        let metaResultsElement = document.getElementById('metaResults');
        let keywordResultsElement = document.getElementById('keywordResults');

        // Validate meta title
        const titleLength = metaTitle.length;
        let titleStatus = '';
        if (titleLength === 0) {
            titleStatus = "Please enter a meta title.";
        } else if (titleLength < 50) {
            titleStatus = `Poor (Too Short - ${titleLength} characters)`;
        } else if (titleLength > 60) {
            titleStatus = `Poor (Too Long - ${titleLength} characters)`;
        } else {
            titleStatus = `Good (Optimal - ${titleLength} characters)`;
        }

        // Validate meta description
        const descriptionLength = metaDescription.length;
        let descriptionStatus = '';
        if (descriptionLength === 0) {
            descriptionStatus = "Please enter a meta description.";
        } else if (descriptionLength < 120) {
            descriptionStatus = `Poor (Too Short - ${descriptionLength} characters)`;
        } else if (descriptionLength > 160) {
            descriptionStatus = `Poor (Too Long - ${descriptionLength} characters)`;
        } else {
            descriptionStatus = `Good (Optimal - ${descriptionLength} characters)`;
        }

        // Display results
        metaResultsElement.innerHTML = `
            <p><strong>Meta Title:</strong> ${titleStatus}</p>
            <p><strong>Meta Description:</strong> ${descriptionStatus}</p>
            <p><strong>Meta Keywords:</strong> ${metaKeywords}</p>
        `;

        // Search for keyword in meta title and description
        let keywordFound = false;
        if (searchKeyword.length > 0) {
            const searchKeywordLC = searchKeyword.toLowerCase();
            if (metaTitle.toLowerCase().includes(searchKeywordLC) || metaDescription.toLowerCase().includes(searchKeywordLC)) {
                keywordFound = true;
            }
        }

        // Display keyword search result
        keywordResultsElement.innerHTML = `
            <p>Keyword "<strong>${searchKeyword}</strong>" ${keywordFound ? 'found' : 'not found'} in Meta Title or Meta Description.</p>
        `;
        keywordResultsElement.className = keywordFound ? 'keyword-result keyword-found' : 'keyword-result keyword-not-found';

        // Extract keywords from meta title and description
        extractKeywords(metaTitle, metaDescription, keywordResultsElement);
    }

    function extractKeywords(metaTitle, metaDescription, keywordResultsElement) {
        // Split text into words (naive approach, can be improved with NLP libraries)
        let titleWords = metaTitle.toLowerCase().match(/\b\w+\b/g) || [];
        let descriptionWords = metaDescription.toLowerCase().match(/\b\w+\b/g) || [];

        // Filtering out common words or stopwords (can be extended for more comprehensive lists)
        const stopwords = ['a', 'an', 'and', 'the', 'is', 'of', 'to', 'in', 'on', 'for', 'with', 'that', 'this', 'it', 'as', 'at'];
        titleWords = titleWords.filter(word => !stopwords.includes(word));
        descriptionWords = descriptionWords.filter(word => !stopwords.includes(word));

        // Counting word frequency
        let wordFrequency = {};
        [...titleWords, ...descriptionWords].forEach(word => {
            if (wordFrequency[word]) {
                wordFrequency[word]++;
            } else {
                wordFrequency[word] = 1;
            }
        });

        // Sorting by frequency
        let sortedKeywords = Object.keys(wordFrequency).sort((a, b) => wordFrequency[b] - wordFrequency[a]);

        // Displaying top 5 keywords
        let topKeywordsHTML = `<p><strong>Top Keywords:</strong></p>`;
        for (let i = 0; i < Math.min(sortedKeywords.length, 5); i++) {
            topKeywordsHTML += `<p>${sortedKeywords[i]} (${wordFrequency[sortedKeywords[i]]} occurrences)</p>`;
        }
        keywordResultsElement.innerHTML += topKeywordsHTML;
    }
</script>
<?php include("layout/footer.php"); ?>