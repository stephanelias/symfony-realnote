# symfony_realnote

##**Entités**

- Album :
    - name : string
    - release_date : date : null
    - artists : relation ( Artist ) : null
    - titles : relation ( Title ) : null
    - cover : relation ( Cover ) : null
    - category : relation ( Category ) : null
- Artist :
    - name : string
    - real_name : string : null
    - birth_date : date : null
    - summary : string : null
    - photo : relation ( Photo ) : null
    - albums : relation ( Album ) : null
  //  - features : relation ( Title ) : null
- Title :
    - name : string
    - album : relation ( Album )
    - feats : relation ( Artist ) : null
- Cover :
    - name : string
- Photo :
    - name : string
- Category :
    - name : string
    - albums : relation ( Album ) : null
- User :
    - login : string
    - password : string
    - roles : json_format
    - user_albums : relation ( UserAlbum ) : null
- UserAlbum :
    - name : string
    - artists_name : string
    - note : integer / double : null
    - user_titles : relation ( UserTitle ) : null
    - cover : relation ( Cover )
- UserTitle :
    - name : string
    - feats : relation ( Feat ) : null
    - note_feat : string : null
    - note_lyrics : string : null
    - note_beat : string : null
    - note_flow : string : null
- Feat :
    - name : string 
