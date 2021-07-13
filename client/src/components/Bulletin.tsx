import React, { useEffect } from 'react';
import Paper from '@material-ui/core/Paper';
import client from '../services/discord';
import {TextChannel} from 'discord.js'

const Bulletin : React.FC = () => {
    useEffect(() => {
        async function getMessages() {
            const announcements = await client.channels.fetch('announcements', true) as any;
            const messages = await announcements.fetchMessages();
            console.log(messages);
        }
    })
    return (
        <Paper>

        </Paper>
    )
}

export default Bulletin;