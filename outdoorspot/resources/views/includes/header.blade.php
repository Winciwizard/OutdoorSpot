<nav class="row">
    <div class="col-8" id="logo_title">
        <a href="#" id="retour-flux">
            <i class="fab fa-hooli fa-2x" aria-hidden="true"></i>
        </a>
    </div>
    <div class="col-4">
        <ul id="menu_connect">
            <li class="menu_icon">
                <a href="#" class="menu_lien">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </li>
            <li class="menu_icon">
                <a href="#" class="menu_lien">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <button type="button" class="btn" data-toggle="modal" data-target="#postSpot">
                    <i class="fa fa-camera-retro" aria-hidden="true" id="menu_share_icon"></i>Partager
                </button>
            </li>
        </ul>
    </div>
</nav>
<div class="modal fade" id="postSpot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Poste ton Spot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('post.create')}}" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="place">Lieu du spot</label>
                        <input type="text" class="form-control" name="place" id="place" placeholder="Où est votre spot">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Votre description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Example file input</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                        <small id="imageHelp" class="form-text text-muted"><i class="fas fa-exclamation-triangle"></i>Uniquement des images en .jpg</small>
                    </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-secondary">Send Spot</button>
                      </div>
                    {{csrf_field()}}
                </form>
            </div>
        </div>
    </div>
</div>