function! MySys()

endfunction 

set history=100
set autoread

let mapleader = ","
let g:mapleader = ","

" Fast editing of the .vimrc
map <leader>e :sp ~/.vimrc<cr>

" When vimrc is edited, reload it
autocmd! bufwritepost .vimrc source ~/.vimrc

set so=7
set ruler "Always show current position
set cmdheight=2 "The commandbar height
set hid "Change buffer - without saving

" Set backspace config
set backspace=eol,start,indent
set whichwrap+=<,>,h,l

" set ignorecase "Ignore case when searching
set hlsearch "Highlight search things
set incsearch "Make search act like search in modern browsers
set magic "Set magic on, for regular expressions
set showmatch "Show matching bracets when text indicator is over them
set mat=2 "How many tenths of a second to blink

" No sound on errors
set noerrorbells
set novisualbell

"###########################
"##       PHP             ##
"###########################
" The php doc plugin
" source ~/.vim/php-doc.vim
inoremap <C-P> <ESC>:call PhpDocSingle()<CR>
nnoremap <C-P> :call PhpDocSingle()<CR>
vnoremap <C-P> :call PhpDocRange()<CR>
 
" run file with PHP CLI (CTRL-M)
:autocmd FileType php noremap <C-M> :w!<CR>
 
" PHP parser check (CTRL-L)
:autocmd FileType php noremap <C-L> :!~/local/php55/bin/php -l -n -d html_erros=off %<CR>

" 去除行末空格
:autocmd FileType php noremap <C-K> :%s/\s\+$//g<CR>
 
" Do use the currently active spell checking for completion though!
" (I love this feature :-)
set complete+=kspell
 
" Taken from http://peterodding.com/code/vim/profile/vimrc
" Make Vim open and close folded text as needed because I can't be bothered to
" do so myself and wouldn't use text folding at all if it wasn't automatic.
set foldmethod=marker
"set foldopen=all
" foldopen=all,insert foldclose=all
 
" Enable enhanced command line completion.
set wildmenu wildmode=list:full
 
" Ignore these filenames during enhanced command line completion.
set wildignore+=*.aux,*.out,*.toc " LaTeX intermediate files
set wildignore+=*.jpg,*.bmp,*.gif " binary images
set wildignore+=*.luac " Lua byte code
set wildignore+=*.o,*.obj,*.exe,*.dll,*.manifest " compiled object files
set wildignore+=*.pyc " Python byte code
set wildignore+=*.spl " compiled spelling word lists
set wildignore+=*.sw? " Vim swap files
 
" Enable completion dictionaries for PHP buffers.
autocmd FileType php set complete+=k~/.vim/dict/PHP.dict
 
" PHP Autocomplete
autocmd FileType php set omnifunc=phpcomplete#CompletePHP
set ofu=syntaxcomplete#Complete
autocmd FileType css set omnifunc=csscomplete#CompleteCSS

 
" You might also find this useful
" PHP Generated Code Highlights (HTML & SQL)
let php_sql_query=1
let php_htmlInStrings=1
"let g:php_folding=2
" set foldmethod=syntax

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" => Colors and Fonts
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
syntax enable "Enable syntax hl

" Set font according to system
 if MySys() == "mac"
   set gfn=Bitstream\ Vera\ Sans\ Mono:h13
   set shell=/bin/bash
 elseif MySys() == "windows"
   set gfn=Bitstream\ Vera\ Sans\ Mono:h10
 elseif MySys() == "linux"
   set gfn=Monospace\ 10
   set shell=/bin/bash
 endif
 
 if has("gui_running")
   set guioptions-=T
   set background=dark
   set t_Co=256
   set guifont=Consolas:h9
   colorscheme oceandeep
   set nu
" else
"   colorscheme oceandeep
"   set guifont=Consolas
"   set background=dark
   set nonu
 endif

" chinese character supported
set fileencodings=utf-8,cp936,gbk,default,latin1
" set fileencoding=utf-8
set encoding=utf-8
set termencoding=utf-8

""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"" => Files and backups
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"" Turn backup off, since most stuff is in SVN, git anyway...
"set nobackup
"set nowb
"set noswapfile


"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" => Text, tab and indent related
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
set expandtab
set shiftwidth=4
set tabstop=4
set smarttab

set lbr
set tw=120

set cindent
set si "Smart indet
set ai "Auto indent
set wrap "Wrap lines

map <leader>t2 :setlocal shiftwidth=2<cr>
map <leader>t4 :setlocal shiftwidth=4<cr>
map <leader>t8 :setlocal shiftwidth=4<cr>

" Tab configuration
map <leader>tn :tabnew %<cr>
map <leader>te :tabedit
map <leader>tc :tabclose<cr>
map <leader>tm :tabmove

""""""""""""""""""""""""""""""
" => Statusline
""""""""""""""""""""""""""""""
" Always hide the statusline
set laststatus=2

" Format the statusline
set statusline=
set statusline+=%f "path to the file in the buffer, relative to current directory
set statusline+=\ %h%1*%m%r%w%0* " flag
set statusline+=\ [%{strlen(&ft)?&ft:'none'}, " filetype
set statusline+=%{&encoding}, " encoding
set statusline+=%{&fileformat}] " file format
set statusline+=\ Line:%l/%L
set statusline+=\ Col:%c

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" => General Abbrevs
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
iab xdate <c-r>=strftime("%d/%m/%y %H:%M:%S")<cr>

map <F2> :NERDTreeToggle<CR>

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" => taglist
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
 let Tlist_Auto_Highlight_Tag = 1
 let Tlist_Auto_Open = 0
 let Tlist_Auto_Update = 1
 let Tlist_Close_On_Select = 0
 let Tlist_Compact_Format = 0
 let Tlist_Display_Prototype = 0
 let Tlist_Display_Tag_Scope = 1
 let Tlist_Enable_Fold_Column = 0
 let Tlist_Exit_OnlyWindow = 0
 let Tlist_File_Fold_Auto_Close = 0
 let Tlist_GainFocus_On_ToggleOpen = 1
 let Tlist_Hightlight_Tag_On_BufEnter = 1
 let Tlist_Inc_Winwidth = 0
 let Tlist_Max_Submenu_Items = 1
 let Tlist_Max_Tag_Length = 30
 let Tlist_Process_File_Always = 0
 let Tlist_Show_Menu = 0
 let Tlist_Show_One_File = 1
 let Tlist_Sort_Type = "order"
 let Tlist_Use_Horiz_Window = 0
 let Tlist_Use_Right_Window = 1
 let Tlist_WinWidth = 40
 let tlist_php_settings = 'php;c:class;i:interfaces;P:properties;D:constant;F:function'

map <silent> <leader>tl :TlistToggle<cr>
map <silent> <F3> :TlistToggle<cr>

function! PHP_CheckSyntax()
    setlocal makeprg=~/local/php/bin/php\ -l\ -n\ -d\ html_erros=off
    setlocal shellpipe=>
    setlocal errorformat=%m
    make %
endfunction

function! Run_PHP()
    setlocal makeprg=~/local/php/bin/php
    make %
endfunction

function! Create_Class()
    let s:fname = bufname("%")
    let s:cname = substitute(s:fname, ".*libs/", "", "g")
    let s:cname = substitute(s:cname, ".php", "", "g")
    let s:cname = substitute(s:cname, "/", "_", "g")
    execute "normal i\<?php\n\nclass " . s:cname . " "
endfunction

function! AddTestToAuto()
    let s:cname = bufname("%")
    let s:cname = substitute(s:cname, ".*libs/", "", "g")
    let s:cname = substitute(s:cname, ".*fp-conf/", "", "g")
    let s:cname = substitute(s:cname, ".php", "", "g")
    let s:cname = substitute(s:cname, "/", "_", "g")
    execute "normal i\nTest_Cases_Manager::addCase(\"" . s:cname . "\");\n"
endfunction


map <leader>ck :call PHP_CheckSyntax()<CR>
map <leader>cc :call Create_Class()<CR>
map <leader>at :call AddTestToAuto()<CR>

map <leader>run :w<CR>:!~/local/php/bin/php %<CR>

map <leader>http :!~/local/apache/bin/apachectl graceful<CR>
map <leader>unix :!dos2unix %<CR>
map <leader>dos :!unix2dos %<CR>
map <leader>ct :!ctags -o ./tags -R *<CR>

if !exists("autocommands_loaded")
    let autocommands_loaded = 1
    au BufNewFile,BufRead *.stpl  set ft=html
    au BufNewFile,BufRead *.as  set ft=php
    au BufNewFile,BufRead *.php  set fileformat=dos
    au BufNewFile,BufRead *.stpl  set fileformat=dos
endif

set runtimepath+=~/.vim/php/

set dictionary-=~/.vim/funclist.txt dictionary+=~/.vim/funclist.txt
set complete-=k complete+=k
"set tags=../tags,../../tags,../../../tags,../../../../tags,../../../../../tags,../../../../../../tags
autocmd BufNewFile,Bufread *.ros,*.inc,*.php set keywordprg=":help"

map <F4> :!tosep<CR>
let g:debuggerMaxDepth = 5

map ca :Calendar<CR>
map ti "=strftime("%Y-%m-%d %H:%M:%S")<CR>P

"tmp for rest test all
noremap <C-J> :!tall<CR>
map cc :call Run_PHP()<CR>
map rr :NERDTreeToggle<CR>
