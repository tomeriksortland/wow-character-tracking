import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import CharacterCard from "@/Components/CharacterCard.jsx";
import {useEffect, useState} from "react";
import axios from "axios";

export default function Dashboard({ auth, myCharacters }) {

    const [characters, setCharacters] = useState(myCharacters)

    useEffect(() => {
        const fetchAndSetCharacters = async () => {
            const response = await axios.get(`api/v1/users/${auth.user.id}/characters`)
            if (response.data.length) {
                setCharacters(response.data);
                return Promise.resolve();
            }

            setTimeout(fetchAndSetCharacters, 1000);
        }

        if(characters.length !== 8) fetchAndSetCharacters()
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My characters</h2>}>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex flex-wrap w-full mt-10 mx-auto">
                        { characters.map((character, index) => (
                            <div key={index} className="w-1/4 px-2 mb-2">
                                <CharacterCard
                                    character={character}
                                    score={character.character_mythic_plus_score}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
