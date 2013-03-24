<div id="ipb-get-members" style="border: 1px solid rgb(0, 0, 0); padding: 2px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; position: absolute; width: 120px; display: none; z-index: 100;"></div>
      <!--in_dev_notes-->
      <!--in_dev_check-->
      <table width="100%" border="0" cellpadding="0" cellspacing="4">
        <tbody>
          <tr>
            <td valign="top" width="75%"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td><div class="homepage_pane_border">
                        <div class="homepage_section">Common Actions</div>
                        <table id="common_actions" width="100%" cellpadding="4" cellspacing="0">
                          <tbody>
                            <tr>
                              <td valign="top" width="33%"><div><a href="" title="Manage Members"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/members.png" alt="Manage Members" border="0"> Manage Members</a></div>
                                <div><a href="" title="Process Validating Members"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/validating.png" alt="Process Validating Members" border="0"> Validating Members</a></div>
                                <div><a href="" title="Manage Forums"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/forums.png" alt="Manage Forums" border="0"> Manage Pages</a></div></td>
                              <td valign="top" width="33%"><div><a href="" title="Edit System Settings"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/settings.png" alt="Edit System Settings" border="0"> Edit System Settings</a></div>
                                <div><a href="" title="Skin Manager"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/skins.png" alt="Skin Manager" border="0"> Skin Manager</a></div>
                                <div><a href="" title="Bulk Mailer"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/bulkmail.png" alt="Bulk Mailer" border="0"> Bulk Mailer</a></div></td>
                              <td valign="top" width="33%"><div><a href="" title="Manage Groups"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/groups.png" alt="Manage Groups" border="0"> Manage Groups</a></div>
                                <div><a href="" title="Language Manager"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/languages.png" alt="Language Manager" border="0"> Language Manager</a></div>
                                <div><a href="" title="Emoticon Manager"><img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/folder_components/index/emos.png" alt="Emoticon Manager" border="0"> Emoticon Manager</a></div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div class="homepage_pane_border">
                        <div class="homepage_section">Tasks and Statistics</div>
                        <table width="100%" cellpadding="4" cellspacing="0">
                          <tbody>
                            <tr>
                              <td valign="top" width="50%"><div class="homepage_border">
                                <div class="homepage_sub_header">Quick Actions</div>
                                <table width="100%" cellpadding="4" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td class="homepage_sub_row"><strong>Find/Edit Member</strong> <span class="desctext" title="Enter a partial name to search for">?</span> <br>
                                        <form name="DOIT" id="DOIT" action="" method="post">
                                          <input name="_admin_auth_key" value="8e54eccc483098e397d81a6623348a36" type="hidden">
                                          <input autocomplete="off" size="33" class="textinput" id="members_display_name" name="members_display_name" value="" type="text">
                                          <input value="Go..." class="realbutton" onclick="edit_member()" type="submit">
                                        </form></td>
                                    </tr>
                                    <tr>
                                      <td class="homepage_sub_row"><strong>Add New Member</strong> <span class="desctext" title="Enter a name and group">?</span> <br>
                                        <form name="newmem" id="newmem" action="" method="post">
                                          <input name="_admin_auth_key" value="8e54eccc483098e397d81a6623348a36" type="hidden">
                                          <input size="17" class="textinput" name="name" value="" type="text">
                                          <select name="mgroup">
                                            <option value="11">Accès temporaire</option>
                                            <option value="6">Administrators</option>
                                            <option value="5">Banned</option>
                                            <option value="7">Developper</option>
                                            <option value="2">Guests</option>
                                            <option value="3">Members</option>
                                            <option value="8">Moderator</option>
                                            <option value="4">Root Admin</option>
                                            <option value="10">Support Team</option>
                                            <option value="1">Validating</option>
                                          </select>
                                          <input value="Go..." class="realbutton" type="submit">
                                        </form></td>
                                    </tr>
                                    <tr>
                                      <td class="homepage_sub_row"><strong>IP Address Search</strong> <span class="desctext" title="Lookup info on an IP address">?</span> <br>
                                        <form name="ipform" id="ipform" action="" method="post">
                                          <input name="_admin_auth_key" value="8e54eccc483098e397d81a6623348a36" type="hidden">
                                          <input size="33" class="textinput" name="ip" value="" type="text">
                                          <input value="Go..." class="realbutton" type="submit">
                                        </form></td>
                                    </tr>
                                    <tr>
                                      <td class="homepage_sub_row"><strong>Search System Settings</strong> <span class="desctext" title="Search for a setting to edit">?</span> <br>
                                        <form name="settingform" id="settingform" action="" method="post">
                                          <input name="_admin_auth_key" value="8e54eccc483098e397d81a6623348a36" type="hidden">
                                          <input size="33" class="textinput" name="search" value="" type="text">
                                          <input value="Go..." class="realbutton" type="submit">
                                        </form></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                              <td valign="top"><div class="homepage_border">
                                  <div class="homepage_sub_header">System Overview</div>
                                  <table width="100%" cellpadding="4" cellspacing="0">
                                    <tbody>
                                      <tr>
                                        <td class="homepage_sub_row" width="60%"><strong>PGM Version</strong> &nbsp;(<a href="">History</a>)</td>
                                        <td class="homepage_sub_row" width="40%"><span style="color: red;">v0.0.1</span></td>
                                      </tr>
                                      <tr>
                                        <td class="homepage_sub_row"><strong>Members</strong></td>
                                        <td class="homepage_sub_row"><a href="">Manage</a> (<strong>990</strong>) </td>
                                      </tr>
                                      <tr>
                                        <td class="homepage_sub_row">&nbsp;&nbsp;|-&nbsp;<strong>Online Users</strong></td>
                                        <td class="homepage_sub_row"><a href="" target="_blank">View Online List</a> (<strong>10</strong>) </td>
                                      </tr>
                                      <tr>
                                        <td class="homepage_sub_row">&nbsp;&nbsp;|-&nbsp;<strong>Awaiting Validation</strong></td>
                                        <td class="homepage_sub_row"><a href="">Manage</a> (<strong>0</strong>) </td>
                                      </tr>
                                      <tr>
                                        <td class="homepage_sub_row">&nbsp;&nbsp;|-&nbsp;<strong>Locked Accounts</strong></td>
                                        <td class="homepage_sub_row"><a href="">Manage</a> (<strong>10</strong>) </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      </div></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table>