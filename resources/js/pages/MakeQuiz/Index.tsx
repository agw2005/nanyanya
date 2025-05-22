import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Toggle } from '@/components/ui/toggle';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Make new quiz',
        href: '/make',
    },
];

export default function Index() {
    const [questionCount, setQuestionCount] = useState(2); // default 2 questions

    const handleQuestionCountChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = parseInt(e.target.value, 10);
        if (!isNaN(value) && value > 0) {
            setQuestionCount(value);
        }
    };

    const [correctAnswers, setCorrectAnswers] = useState<Record<number, string>>({});

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Make new quiz" />
            <div>
                <form action="">
                    <div>
                        <Label htmlFor="Quiz name">Quiz Name</Label>
                        <Input placeholder="Ex: PyTorch Exam"></Input>
                    </div>
                    {/* <div>
                        <Label htmlFor="Quiz thumbnail">Quiz Thumbnail</Label>
                        <Input placeholder="jpeg or png"></Input>
                    </div> */}
                    <div>
                        <Label htmlFor="Quiz question quantity">Questions Quantity</Label>
                        <Input
                            id="questions-quantity"
                            type="number"
                            value={questionCount}
                            onChange={handleQuestionCountChange}
                            placeholder="Ex: 10"
                        />
                    </div>
                    {Array.from({ length: questionCount }).map((_, index) => (
                        <div key={index}>
                            <div>
                                <Label htmlFor={`question-${index}`}>Question {index + 1} - Question</Label>
                                <Textarea id={`question-${index}`} placeholder={`Ex: What is ${index}+${index}?`} />
                            </div>
                            {['A', 'B', 'C', 'D'].map((option) => (
                                <div key={option}>
                                    <div>
                                        <Label htmlFor={`question-${index}-option-${option}`}>
                                            Question {index + 1} - Option {option}
                                        </Label>
                                        <Toggle
                                            pressed={correctAnswers[index] === option}
                                            onClick={() => {
                                                setCorrectAnswers((prev) => ({
                                                    ...prev,
                                                    [index]: option,    
                                                }));
                                            }}
                                        >
                                            Correct Answer
                                        </Toggle>
                                    </div>
                                    <Input id={`question-${index}-option-${option}`} placeholder={`Option ${option}`} />
                                </div>
                            ))}
                        </div>
                    ))}
                    <Button type="submit">Create Quiz</Button>
                </form>
            </div>
        </AppLayout>
    );
}
